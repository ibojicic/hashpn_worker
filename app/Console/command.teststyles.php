<?php
/**
 * Created by PhpStorm.
 * User: ibojicic
 * Date: 8/1/2017
 * Time: 4:34 PM
 */
namespace HashPN\App\Console;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestStyles extends Command
{

    public function __construct($name = null)
    {
        parent::__construct($name);

    }

    public function configure()
    {
        $this->setName('test')
            ->setDescription('test styles.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input,$output);


        $io->title("'title' test");

        $io->section("'section' Adding a User");

        $io->text("'text' Lorem ipsum dolor sit amet");

        $io->note("'note' Lorem ipsum dolor sit amet");

        $io->caution("'caution' Lorem ipsum dolor sit amet");

        $io->success("'success' Lorem ipsum dolor sit amet");

        $io->warning("'warning' Lorem ipsum dolor sit amet");

        $io->error("'error' Lorem ipsum dolor sit amet");

        $io->listing(array(
            "'listing'",
            'Element #1 Lorem ipsum dolor sit amet',
            'Element #2 Lorem ipsum dolor sit amet',
            'Element #3 Lorem ipsum dolor sit amet',
        ));

        // outputs a single blank line
        $io->title("before 'newLine'");
        $io->newLine();
        //$io->newLine(3);
        $io->title("after 'newLine'");


        // displays a progress bar of unknown length
        $io->progressStart();
        // displays a 100-step length progress bar
        $io->progressStart(100);

        // advances the progress bar 1 step
        $io->progressAdvance();

        // advances the progress bar 10 steps
        $io->progressAdvance(10);

        $io->progressFinish();
        /*

        $io->ask('What is your name?');

        $res = $io->ask('Where are you from?', 'United States');

        $io->text("You said " . $res);

        $io->askHidden('What is your password?');

        $inp = $io->confirm('Restart the web server?');

        $io->text("You said " . $inp);

        $inp = $io->confirm('Restart the web server?', true);

        $io->text("You said " . $inp);

        $io->choice('Select the queue to analyze', array('queue1', 'queue2', 'queue3'));

        $io->choice('Select the queue to analyze', array('queue1', 'queue2', 'queue3'), 'queue1');
        */




    }


}