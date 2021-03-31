<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 8/1/2017
 * Time: 4:34 PM
 */
namespace HashPN\App\Console;

use HashPN\App\Common\BrewImages;
use HashPN\App\Common\PNGMenu;
use HashPN\App\Common\qObject;
use HashPN\App\Parsers\ParseInputs;
use HashPN\Models\MainGPN\PNMain;
use HashPN\Models\PNImages\pngimagesinfo;
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
use Symfony\Component\Console\Input\ArrayInput;

class fcharts extends Command
{

    public $mylogger;
    public $config;

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    public function configure()
    {
        $this->setName('fcharts')
            ->setDescription('Create finding charts.')
            ->addArgument('image', InputArgument::REQUIRED,
                "Image or list of images divided by comma. 'all' for all available images.")
            ->addArgument('id', InputArgument::REQUIRED,
                "Objects id or list of ids divided by comma. 'all' for all objects in the database.")
            ->addOption('rewrite', 'w', InputOption::VALUE_NONE,
                'Rewrite existing images.')
            ->addOption('idquery', 'i', InputOption::VALUE_REQUIRED,
                "Choose objects from an SQL query. Query must be on the MainGPN.PNMain table. ID(s) in the 'id' argument must be 'all'.")
            ->addOption('emailme', 'e', InputOption::VALUE_REQUIRED,
                "Send an email to 'email@server.etc' with log file when finished.");

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->config = new MyConfig();
        $this->config->setLogFile(MyFunctions::getMethod($this));
        $this->mylogger = new MyLogger($this->config->getLogfile());

        $io = new SymfonyStyle($input, $output);
        $io->title("Start brewing.....");

        $symlogger = new ConsoleLogger($output);
        $this->mylogger->setSymlogger($symlogger);

        //*************************************
        // check inputs, stop on error
        $parsed_images = ParseInputs::parseSets($input->getArgument('image'),'brew');
        $parsed_objects = ParseInputs::parseIDs($input->getArgument('id'),$input->getOption('idquery'));
        if (!empty($parsed_images['notfound'])) {
            $this->mylogger->logMessage("Problem with input sets: " . implode(",",$parsed_images['notfound']),$this,'error');
        }
        if (!$parsed_objects || empty($parsed_objects)) {
            $this->mylogger->logMessage("Problem with input ids " . implode(",",$parsed_objects),$this,'error');
        }
        $io->text("Surveys and IDs check...pass");
        //***********************************

        $brewer = $this->getApplication()->find('brew');


        foreach ($parsed_images['found'] as $image_type) {
            foreach ($parsed_objects as $id) {
                $arguments = [
                    'command' => 'brew',
                    'image' => $image_type,
                    'id'    => $id,
                    '-m'  => 'f'
                ];
                $arguments_input = new ArrayInput($arguments);
                $return = $brewer->run($arguments_input,$output);

            }

        }
        $io->newLine();
        $io->note("Bye, bye....");


    }



}