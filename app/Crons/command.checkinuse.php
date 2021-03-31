<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 8/1/2017
 * Time: 4:34 PM
 */
namespace HashPN\App\Crons;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use MyPHP\MyConfig;
use MyPHP\MyFunctions;
use MyPHP\MyLogger;
use MyPHP\MyStandards;
use HashPN\Models\MainGPN\tablesInfo;
use MyPHP\MyMailer;

class checkinuse extends Command
{
    use MyStandards;

    public $mylogger;
    public $config;

    public function configure()
    {
        $this->setName('checkinuse')
            ->setDescription('Check InUse fields and notice the administrator on duplicates.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->config = new MyConfig();
        $this->config->setLogFile(MyFunctions::getMethod($this));
        $this->mylogger = new MyLogger($this->config->getLogfile());

        $tablesInfo = tablesInfo::whereNotIn('varTable',['PNMain','tbUsrComm'])
            ->groupBy('varTable')
            ->get();

        $duplicates = [];

        foreach ($tablesInfo as $table) {
            $model_name = $this->getModelFromName(MODEL_NAMESPACE,'MainGPN',$table->varTable);
            $model = new $model_name;
            if ($table->bandMapped == 'n') {
                $results = $model
                    ->where('InUse',1)
                    ->groupBy('idPNMain')
                    ->havingRaw("COUNT(`idPNMain`) > 1")
                    ->get()
                    ->toArray();
            } else {
                $results = $model
                    ->where('InUse',1)
                    ->where('band',$table->band)
                    ->groupBy('idPNMain')
                    ->havingRaw("COUNT(`idPNMain`) > 1")
                    ->get()
                    ->toArray();
            }
            if (!empty($results)) {
                $duplicates[$table->varTable] = $results;
            }
        }
        if (!empty($duplicates)) {
            $this->_sendWarning($duplicates);
        }
    }


    private function _sendWarning($duplicates) {
        $mail_par = $this->config->mail;
        $mailer = new MyMailer($mail_par['db_name'],$mail_par['db_email'],$mail_par['db_password']);
        $mailer->sendEmail($mail_par['admin_email'],$mail_par['admin_name'],'duplicate InUse found',$this->_setMessage($mail_par['admin_name'],$duplicates));
    }

    private function _setMessage($name,$duplicates) {
        $message = "Hi $name,<br>It appears that following records have duplicate 'InUse':<br><br>";
        foreach ($duplicates as $table => $data) {
            $message .= "Table: MainGPN." . $table . "<br>";
            foreach ($data as $duplicateInUse) {
                $message .= "idPNMain:" . $duplicateInUse['idPNMain'] . "<br>";
            }
            $message .= "<br>";
        }
        $message .= "Please correct these asap.<br><br>Cheers,<br>HASH PN Database<br>";
        return $message;
    }


}

