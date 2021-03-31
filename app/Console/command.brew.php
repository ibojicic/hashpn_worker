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

class brew extends Command
{

    public $mylogger;
    public $config;

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    public function configure()
    {
        $this->setName('brew')
            ->setDescription('Brew png images.')
            ->addArgument('image', InputArgument::REQUIRED,
                "Image or list of images divided by comma. 'all' for all available images.")
            ->addArgument('id', InputArgument::REQUIRED,
                "Objects id or list of ids divided by comma. 'all' for all objects in the database.")
            ->addOption('rewrite', 'w', InputOption::VALUE_NONE,
                'Rewrite existing images.')
            ->addOption('idquery', 'i', InputOption::VALUE_REQUIRED,
                "Choose objects from an SQL query. Query must be on the MainGPN.PNMain table. ID(s) in the 'id' argument must be 'all'.")
            ->addOption('emailme', 'e', InputOption::VALUE_REQUIRED,
                "Send an email to 'email@server.etc' with log file when finished.")
            ->addOption('make', 'm', InputOption::VALUE_REQUIRED,
                "Images to be created (m:main image,t:thumbnail,o:overlay,f:finding chart), by default mto.", 'mto');

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


        //*************************************
        // create PNGmeny objects for input images
        $images = [];
        foreach ($parsed_images['found'] as $current_image) {
            array_push($images, new PNGMenu($current_image));
        }
        $io->text("Create PNGMenu objects...pass");
        //*************************************

        //************* start loop trough selected objects ******************
        foreach ($parsed_objects as $current_object) {

            //** open object container */
            $object = new qObject($current_object);
            $object->setMyLogger($this->mylogger);
            $this->mylogger->logMessage("Working on object:" . $object->getIdPNMain(), $this, 'info');

            //** loop trough selected images */
            foreach ($images as $image) {

                //** set loggers for survey*/
                $image->setMyLogger($this->mylogger);
                $this->mylogger->logMessage("Working on image:" . $image->getImageParams('name'), $this, 'info');

                //** creete new brewery */
                $brewery = new BrewImages();

                //** set input parameters */
                $brewery->setSet($image->getImageParams('name'))
                    ->setMyLogger($this->mylogger)
                    ->setQobject($object)
                    ->setImage($image)
                    ->setOutoptions($input->getOption('make'))
                    ->setOldresultsmodel();

                //** if rewrite delete old images and db inputs */
                if ($input->getOption('rewrite')) {
                    $brewery->deleteOldResults([]);
                }

                //** retreive old results for comparison */
                $brewery->setOldresults();

                //** if no input images skip to the next object */
                if (!$brewery->setImagesets()) {
                    continue;
                }

                //** set recipe for brewing */
                $recipe = $brewery->setRecipes();
                //** if recipe pass the validation brew */
                if ($recipe) {
                    $brewery->brew($recipe);

                    //** prepare input results */
                    $results = $brewery->prepareResults();

                    //** delete old results */
                    $noDeleted = $brewery->deleteOldResults($results);

                    //** record results to the db */
                    $created = $brewery->recImagingResultsToDB($results);

                    $this->mylogger->logMessage("Deleted: $noDeleted, inserted: ".count($created), $this, 'info');
                    $this->mylogger->logMessage("Finished...", $this, 'info');
                }

            }
            //** kill object */
            unset($object);
            //** kill brewery */
            unset($brewery);
        }

        $io->newLine();
        $io->note("Bye, bye....");


    }


}