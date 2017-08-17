<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 8/16/17
 * Time: 10:19 PM
 */

namespace csv2dml\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Convert extends Command
{
    protected function configure()
    {
        $this->setName('convert')->setDescription('Reads in a CSV and outputs DSX DML');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello World');
    }
}