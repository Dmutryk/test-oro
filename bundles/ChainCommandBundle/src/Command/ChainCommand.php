<?php

declare(strict_types=1);

namespace ChainCommandBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'chain:command',
    description: 'Command just for test purpose.'
)]
class ChainCommand extends Command
{
    protected function configure(): void
    {
        $this->setDescription('Master command for chaining other commands');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Implement logic to execute chained commands
        $output->writeln('Executing master command.');

        return Command::SUCCESS;
    }
}
