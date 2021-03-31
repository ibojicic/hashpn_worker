<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 8/1/2017
 * Time: 4:34 PM
 */
namespace HashPN\App\Console;

use HashPN\App\Common\qObject;
use HashPN\App\Common\Survey;
use HashPN\App\Fetchers\FetchImages;
use HashPN\App\Parsers\ParseInputs;
use HashPN\Models\MainGPN\PNMain;
use HashPN\Models\PNImages\Imagesets;
use MyPHP\MyConfig;
use MyPHP\MyFunctions;
use MyPHP\MyLogger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class fetch extends Command
{

    public $mylogger;
    public $config;

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    public function configure()
    {
        $this->setName('fetch')
            ->setDescription('Fetch fits images.')
            ->addArgument('survey', InputArgument::REQUIRED,
                "Survey or list of surveys divided by comma. 'all' for all available surveys.")
            ->addArgument('id', InputArgument::REQUIRED,
                "Objects id or list of ids divided by comma. 'all' for all objects in the database.")
            ->addOption('rewrite', 'w', InputOption::VALUE_REQUIRED,
                'Rewrite existing images. force: force fech images (rewrite old); redo: fetch new images (do not rewrite old); new: only fetch images for objects not checked before',
                'new')
            ->addOption('idquery', 'i', InputOption::VALUE_REQUIRED,
                "Choose objects from an SQL query. Query must be on the MainGPN.PNMain table. ID(s) in the 'id' argument must be 'all'.")
            ->addOption('emailme', 'e', InputOption::VALUE_REQUIRED,
                "Send an email to 'email@server.etc' with log file when finished."
            );

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->config = new MyConfig();
        $this->config->setLogFile(MyFunctions::getMethod($this));
        $this->mylogger = new MyLogger($this->config->getLogfile());

        $io = new SymfonyStyle($input,$output);
        $io->title("Start fetching.....");

        $symlogger = new ConsoleLogger($output);
        $this->mylogger->setSymlogger($symlogger);

        //*************************************
        // check inputs, stop on error
        $parsed_surveys = ParseInputs::parseSets($input->getArgument('survey'),'fetch');
        $parsed_objects = ParseInputs::parseIDs($input->getArgument('id'),$input->getOption('idquery'));

        if (!empty($parsed_surveys['notfound'])) {
           $this->mylogger->logMessage("Problem with input sets: " . implode(",",$parsed_surveys['notfound']),$this,'error');
        }

        if (!$parsed_objects || empty($parsed_objects)) {
            $this->mylogger->logMessage("Problem with input ids " . implode(",",$parsed_objects),$this,'error');
        }

        $io->section("Surveys and IDs check...pass");
        //***********************************

        //*************************************
        // create Survey objects for input surveys
        $surveys = [];
        foreach ($parsed_surveys['found'] as $current_survey) {
            array_push($surveys, new Survey($current_survey));
        }
        $io->section("Create Survey objects...pass");
        //*************************************

        //************* start loop trough selected objects ******************
        foreach ($parsed_objects as $current_object) {

            //** open object container */
            $object = new qObject($current_object);
            $object->setMyLogger($this->mylogger);
            $io->section("Working on object:".$object->getIdPNMain());
            $this->mylogger->logMessage("Working on object:".$object->getIdPNMain(),$this,'info');

            //** loop trough selected surveys */
            foreach ($surveys as $survey) {
                //** set loggers for survey*/
                $survey->setMyLogger($this->mylogger);
                $io->section("Working on survey:".$survey->getSurveyParams('set'));
                $this->mylogger->logMessage("Working on survey:".$survey->getSurveyParams('set'),$this,'info');

                //** set fetching parameters */
                $imfetch = new FetchImages($survey, $object, $this->config);
                $imfetch->setMyLogger($this->mylogger);
                $this->mylogger->logMessage("Setup fethching parameters.",$this,'info');

                //** set fetcher */
                $imfetch->attachFetcher($input->getOption('rewrite'));
                $this->mylogger->logMessage("Attach fetcher.",$this,'info');

                //** if no problem with setting fetcher */
                if ($imfetch->okflag) {

                    //** exec fetching images */
                    $this->mylogger->logMessage("Start fetching.",$this,"info");
                    $fetch_results = $imfetch->fetcher->fetchit();

                    //** if no problem with fetching images */
                    if ($fetch_results) {
                        //** set and check results */
                        $imfetch->fetcher->setResults($fetch_results);
                        //** record fetched reseults to the database (PNImages.surveyname) */
                        $this->mylogger->logMessage("Setting results into db.",$this,'info');
                        $recordResults = $imfetch->recFetchingResultsToDB($imfetch->fetcher->getresults());
                        if ($recordResults) {
                            $imfetch->setResultsInUse();
                        }

                    } else {
                        //** output errors if fetching went wrong */
                        $this->mylogger->logMessage("Problems with fetching.",$this,'warning');
                    }
                }

                $this->mylogger->logMessage("Finished...",$this,'info');

                //** kill fetcher */
                unset($imfetch);
            }
            //** kill object */
            unset($object);
        }

        $io->newLine();
        $io->section("Bye, bye....");

    }



}