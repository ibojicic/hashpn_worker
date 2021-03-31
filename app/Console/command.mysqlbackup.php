<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 8/1/2017
 * Time: 4:34 PM
 */
namespace HashPN\App\Console;

use MyPHP\MyConfig;
use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class mysqlbackup extends Command
{

    private $_config;

    public function configure()
    {
        $this->setName('mysqlbackup')
            ->setDescription('Backup the HASH PN MySQL database.')
            ->addArgument('tofile',  InputArgument::OPTIONAL,
                "Full path to the output mysqldump file.", False)
        ;
    }


    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->_config = new MyConfig();
        $mysqluser = 'mysqlbackup';
        $tofile = $input->getArgument("tofile");

        date_default_timezone_set('Asia/Hong_Kong');
        if ($tofile) {
            if (is_file($tofile)) {
                die ("File ".$tofile." exists!\n");
            }
            $filename = $input->getArgument("tofile");
        } else {
            $filename = SQL_DUMPS . "sql_backup_" . date("Y-m-d-H-i-s") . ".sql";
        }
        $username =escapeshellcmd($mysqluser);
        $password =escapeshellcmd($this->_config->mysqls[$mysqluser]);
        $hostname =escapeshellcmd('niksicko');
        $database =escapeshellcmd('--all-databases --events --complete-insert --single-transaction');
        $filename = escapeshellcmd($filename);
        $command = "mysqldump --force -u$username -p$password -h$hostname $database > $filename";
        system($command, $result);
        echo $result;
        if (is_file($filename) and !$tofile) {
            system("gzip ".$filename);
        }
    }


}