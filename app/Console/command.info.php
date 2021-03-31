<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 8/1/2017
 * Time: 4:34 PM
 */
namespace HashPN\App\Console;

use HashPN\App\Parsers\ParseInputs;
use \Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Style\SymfonyStyle;

class info extends Command
{

    public function configure()
    {
        $this->setName('info')
            ->setDescription('Print info about available surveys/images (for the fetch/brew/spetch script).')
            ->addArgument('what',  InputArgument::REQUIRED,
                "Select between 'fetch','brew' and 'spetch'.")
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $what = $input->getArgument('what');
        $io->section("Available " . $what);

        $list = ParseInputs::getFullSets($what);

        $printout = [];
        $header = ["ID","Name"];

        foreach ($list as $key => $val) {
            array_push($printout, [$key,$val]);
        }

        $outtable = new Table($output);

        $outtable
            ->setHeaders($header)
            ->setRows($printout)
        ;


        $outtable->render();
    }


}