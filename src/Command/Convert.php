<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 8/16/17
 * Time: 10:19 PM
 */

namespace csv2dml\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use parseCSV;
use Sage\DSX\DML;

class Convert extends Command
{
    protected function configure()
    {
        $this->setName('convert')
            ->setDescription('Reads in a CSV and outputs DSX DML')
            ->setDefinition(
                new InputDefinition(array(
                    new InputArgument('in-file',
                        InputArgument::REQUIRED,
                        'Input file containing CSV data'
                    ),
                    new InputArgument(
                        'out-file',
                        InputArgument::OPTIONAL,
                        'Output file where DML should be written',
                        null
                    ),
                    new InputOption(
                        'identifier-pad-length',
                        'p',
                        InputOption::VALUE_OPTIONAL,
                        'The amount of digits the identifier should be padded with',
                        0
                    ),
                ))
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Store the file paths in vars
        $csv_path = $input->getArgument('in-file');
        $out_path = $input->getArgument('out-file');
        $pad = $input->getOption('identifier-pad-length');
        if (empty($out_path)) $out_path = $csv_path . '.dml';
        // Create CSV parser
        $csv = new parseCSV();
        // Create the DML formatter
        $dml = new DML();
        // Array to store dml output
        $dml_cmds = array();
        $c = 0;

        // Read the CSV
        $output->write('Reading CSV(' . $csv_path . ') ... ');
        $csv->auto($csv_path);
        $output->writeln(' Done!');

        $output->write('Generating DML .');
        foreach ($csv->data as $record) {
            if ($c > 100) {
                $output->write('.');
                $c = 0;
            }
            $c++;
            $identifier = $this->pad($pad, $record['identifier']);
            $company = $record['company'];
            $email = $record['email'];
            $first_name = $record['first_name'];
            $last_name = $record['last_name'];

            $dml_cmds[] = $dml->set_id($identifier);
            $dml_cmds[] = $dml->set_table('Names');
            $dml_cmds[] = $dml->set_field('FName', $first_name);
            $dml_cmds[] = $dml->set_field('LName', $last_name);
            $dml_cmds[] = $dml->set_field('Company ', $company);
            $dml_cmds[] = $dml->cmd_write();

            $dml_cmds[] = $dml->set_table('UDF');
            $dml_cmds[] = $dml->set_field('UdfNum ', '1');
            $dml_cmds[] = $dml->set_field('UdfText', $identifier);
            $dml_cmds[] = $dml->cmd_write();

            $dml_cmds[] = $dml->set_table('UDF');
            $dml_cmds[] = $dml->set_field('UdfNum ', '2');
            $dml_cmds[] = $dml->set_field('UdfText', $email);
            $dml_cmds[] = $dml->cmd_write();
        }
        $cmd_string = implode("\n", $dml_cmds);
        $output->writeln(' Done!');

        $output->write('Writing DML(' . $out_path . ') ... ');
        file_put_contents($out_path, $cmd_string);
        $output->writeln(' Done!');
    }

    /**
     * @param $pad
     * @param $identifier
     * @return string
     */
    protected function pad($pad, $identifier)
    {
        $i_length = strlen($identifier);
        if ($i_length < $pad) {
            $diff = $pad - $i_length;
            for ($i = 1; $i <= $diff; $i++) {
                $identifier = '0' . $identifier;
            }
        }
        return $identifier;
    }
}