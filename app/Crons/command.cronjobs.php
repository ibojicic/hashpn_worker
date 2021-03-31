<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 8/1/2017
 * Time: 4:34 PM
 */
namespace HashPN\App\Crons;

use \Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use MyPHP\MyConfig;
use MyPHP\MyFunctions;
use MyPHP\MyLogger;
use HashPN\Models\MainPNUsers\cronJobs as cronJobsModel;
use Carbon\Carbon as Carbon;

class cronjobs extends Command
{

    public $mylogger;
    public $config;

    public function configure()
    {
        $this->setName('cronjobs')
            ->setDescription('Manipulate HASH PN cron jobs.')
            ->addArgument('cronit', InputArgument::REQUIRED,
                "Directive to be applied to cron jobs list. Select between: show, exec, restart.")
            ->addOption('no-processes', 'p',InputArgument::OPTIONAL,
                "Maximum number of processes to run simultaneously.",5)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
//        $this->config = new MyConfig();
//        $this->config->setLogFile(MyFunctions::getMethod($this));
//        $this->mylogger = new MyLogger($this->config->getLogfile());

//        $mode = $input->getArgument('cronit');

//        $max_proc = $input->getOption('no-processes');

        $inprocess = cronJobsModel::whereNull('date_exec')
            ->where('zombie','n')
            ->orderBy('date_subm')
            ->whereNotNull('date_start')
            ->first();

        if ($inprocess) {
            $this->_checkZombie($inprocess);
        } else {
            $toprocess = cronJobsModel::whereNull('date_exec')
                ->where('zombie', 'n')
                ->orderBy('date_subm')
                ->whereNull('date_start')
                ->first();
            if ($toprocess) {
                $this->_runProcess($toprocess);
            }
        }


    }

    private function _checkZombie($inprocess) {

        foreach ($inprocess as $process) {
            $runtime = (time() - strtotime($process->date_start)) / (24 * 3600);
            if ($runtime > 1) {
                $this->_emailUser($process);
                $this->_setZombie($process);
            }
        }
    }

    private function _emailUser($process) {

    }

    private function _setZombie($process) {
        $process->zombie = 'y';
        $process->save();
    }

    private function _runProcess($process) {
        $command = $process->cronScript;
        $options = unserialize($process->parameters);
        foreach ($options as $opt=>$val) {
            $command .= " -$opt $val";
        }
        $process->processID = getmypid();
        $process->date_start = Carbon::now();
        $process->save();
        shell_exec("hashpn " . $command);
        $process->date_exec = Carbon::now();
        $process->save();
    }


}

