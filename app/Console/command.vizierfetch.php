<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 8/1/2017
 * Time: 4:34 PM
 */
namespace HashPN\App\Console;

use MyPHP\MyConfig;
use MyPHP\MyFunctions;
use MyPHP\MyLogger;
use MyPHP\MyPythons;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class insertobjects_vizier extends Command
{

    use MyPythons;

    public $mylogger;
    public $config;
    public $name;

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    public function configure()
    {
        $this->setName('insertobjects')
            ->setDescription('Inserts a set of objects into HASH PN database from a file')
            ->addArgument('filename', InputArgument::REQUIRED,
                "Full path to the file with the data to be inserted.")
            ->addOption("exclude", "e", InputArgument::OPTIONAL,
                "Automatically exclude possible duplicates within range (arcsec).", 30);

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->config = new MyConfig();
        $this->config->setLogFile(MyFunctions::getMethod($this));
        $this->mylogger = new MyLogger($this->config->getLogfile());

        /*******************************/
        //** set styling objects */
        $io = new SymfonyStyle($input, $output);
        $io->title("Start.....");
        /*******************************/

        /*******************************/
        //** set mylogger */
        $symlogger = new ConsoleLogger($output);
        $this->mylogger->setSymlogger($symlogger);
        /*******************************/




    }



}