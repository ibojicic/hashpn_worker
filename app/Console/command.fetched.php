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
use HashPN\Models\MainGPN\PNMain;
use HashPN\Models\PNImages\Imagesets;
use MyPHP\MyConfig;
use MyPHP\MyFunctions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class fetched extends Command
{
    public $mylogger;
    public $config;

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    public function configure()
    {
        $this->setName('fetched')
            ->setDescription('Check fetched fits images.')
            ->addArgument('survey', InputArgument::REQUIRED,
                "Survey or list of surveys divided by comma. 'all' for all available surveys.")
            ->addArgument('id', InputArgument::REQUIRED,
                "Objects id or list of ids divided by comma. 'all' for all objects in the database.")
            ->addOption('idquery', 'i', InputOption::VALUE_REQUIRED,
                "Choose objects from an SQL query. Query must be on the MainGPN.PNMain table. ID(s) in the 'id' argument must be 'all'.")
            ->addOption('found', 'f', InputOption::VALUE_REQUIRED,
                "Select only found(-f y) or not found(-f n)");

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->config = new MyConfig();
        $this->config->setLogFile(MyFunctions::getMethod($this));

        $outtable = new Table($output);
        $io = new SymfonyStyle($input, $output);
        $found = $input->getOption('found') == null ? false : $input->getOption('found');

        //*************************************
        // check inputs, stop on error
        $parsed_surveys = $this->_parseInputs('survey', $input->getArgument('survey'));
        $parsed_objects = $this->_parseInputs('id', $input->getArgument('id'), $input->getOption('idquery'));
        if (!($parsed_surveys && $parsed_objects)) {
            exit();
        }
        //***********************************

        //*************************************
        // create Survey objects for input surveys
        $surveys = [];
        foreach ($parsed_surveys as $current_survey) {
            array_push($surveys, new Survey($current_survey));
        }
        //*************************************

        $fieldsToShow = [
            'used_RAJ2000' => 'RA',
            'used_DECJ2000' => 'DEC',
            'found' => 'found',
            'band' => 'band',
            'filename' => 'filename',
            'inuse' => 'use',
            'created_at' => 'date'
        ];

        $resultsToShow = [];

        //************* start loop trough selected objects ******************
        foreach ($parsed_objects as $current_object) {

            $resultsToShow = [];
            $io->section("ID = " . $current_object);
            //** open object container */
            $object = new qObject($current_object);

            //** loop trough selected surveys */
            foreach ($surveys as $survey) {
                //** set loggers for survey*/

                //** set fetching parameters */
                $imfetch = new FetchImages($survey, $object, $this->config);

                if (!$found) {
                    $fetched = $imfetch->getResults()->get(array_flip($fieldsToShow))->toArray();
                } else {
                    $fetched = $imfetch->getResults()->where('found',
                        $found)->get(array_flip($fieldsToShow))->toArray();
                }

                if (!empty($fetched)) {
                    array_push($resultsToShow, new TableSeparator());

                    if (is_array($fetched[0])) {
                        foreach ($fetched as $underfetched) {
                            array_unshift($underfetched, $survey->getSurveyParams('set'));
                            array_push($resultsToShow, $underfetched);
                        }
                    } else {
                        array_unshift($fetched, $survey->getSurveyParams('set'));
                        array_push($resultsToShow, $fetched);
                    }

                }

                //** kill fetcher */
                unset($imfetch);
            }

            array_unshift($fieldsToShow, 'survey');

            $outtable
                ->setHeaders($fieldsToShow)
                ->setRows($resultsToShow);
            $outtable->render();
            $io->newLine();

            //** kill object */
            unset($object);
        }
        $io->newLine();
        $io->note("Bye, bye....");
    }

    /**
     * @param $type string type of the input survey/id
     * @param $input string of surveys divided by comma or 'all' for a;; surveys
     * @param bool|string $where sql WHERE
     * @return array|bool array of survey names or False on error
     */
    private function _parseInputs($type, $input, $where = false)
    {
        $all = false;
        $result = array_map('trim', explode(",", $input));
        switch ($type) {
            case 'survey':
                $all = Imagesets::where('use', 'y')->pluck('set')->toArray();
                break;
            case 'id':
                $all = $this->_getObjectsIDs($where);
                break;
        }
        if ($input == 'all') {
            $result = $all;
        } else {
            $crossection = array_diff($result, $all);
            if ($crossection != []) {
                $format = "%s: %s=%s do not exists!";
                return $this->mylogger->logMessage(sprintf($format, __METHOD__, $type, implode(",", $crossection)),
                    $this, 'error', false);
            }
        }
        return $result;
    }

    private function _getObjectsIDs($where = false)
    {
        if (isset($where) and $where) {
            return PNMain::whereRaw($where)
                ->pluck('idPNMain')
                ->toArray();
        } else {
            return PNMain::pluck('idPNMain')
                ->toArray();
        }
    }


}