<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 8/1/2017
 * Time: 4:34 PM
 */
namespace HashPN\App\Console;

use HashPN\App\Common\ParseSpectra;
use HashPN\App\Parsers\ParseInputs;
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

class spetch extends Command
{

    public $mylogger;
    public $config;

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    public function configure()
    {
        $this->setName('spetch')
            ->setDescription('Fetch and parse spectra.')
            ->addArgument('survey', InputArgument::REQUIRED,
                "Survey or list of surveys divided by comma. 'all' for all available surveys.")
            ->addArgument('id', InputArgument::REQUIRED,
                "Objects id or list of ids divided by comma. 'all' for all objects in the database.")
            ->addOption('rewrite', 'w', InputOption::VALUE_NONE,
                'Rewrite existing images.')
            ->addOption('idquery', 'i', InputOption::VALUE_REQUIRED,
                "Choose objects from an SQL query. Query must be on the MainGPN.PNMain table. ID(s) in the 'id' argument must be 'all'.")
            ->addOption('emailme', 'e', InputOption::VALUE_REQUIRED,
                "Send an email to 'email@server.etc' with log file when finished.")
            ->addOption('fill', 'f', InputOption::VALUE_NONE,
                "Run spectra db filler and stop after finished."
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->config = new MyConfig();
        $this->config->setLogFile(MyFunctions::getMethod($this));
        $this->mylogger = new MyLogger($this->config->getLogfile());

        $io = new SymfonyStyle($input,$output);
        $io->title("Start spetching.....");

        $symlogger = new ConsoleLogger($output);
        $this->mylogger->setSymlogger($symlogger);

        //*************************************
        // check inputs, stop on error
        $parsed_surveys = ParseInputs::parseSets($input->getArgument('survey'),'spetch');
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
        // run through surveys and fetch spectra
        $parseSpectra  = new ParseSpectra($input->getOption('rewrite'));

        if ($input->getOption('fill')) {

            $parseSpectra->SPECTRA_dbfiller($parsed_surveys['found']);

            exit();
        }

        foreach ($parsed_objects as $id) {
            $resarray = [];

            foreach ($parsed_surveys['found'] as $current_survey) {
                $io->section("Working on " . $current_survey);

                if ($current_survey == 'eelcat') {
                    $parseSpectra->parseeELCATData($id);
                } else {
                    $parseSpectra->setPaths($id);
                    $parseSpectra->setOutTxtFile($id);
                    $spectradata = $parseSpectra->getBasicData($id, $current_survey);
                    if ($spectradata) {
                        foreach ($spectradata as $spdata) {
                            if (is_file("/data/mashtun/" . MyFunctions::pathslash($spdata['spectra_info']['path']) . $spdata['fileName'])) {
                                array_push($resarray, $parseSpectra->copySpectra($spdata));
                            } else
                                echo "File is missing...\n";
                        }
                        $parseSpectra->setObjectsSpectraFile($id, $resarray);

                    }
                }

            }

        }
        //*************************************
        //*************************************

        $io->newLine();
        $io->section("Bye, bye....");

    }



}