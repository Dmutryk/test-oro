<?php

declare(strict_types=1);

namespace BarBundle\Command;

use Monolog\Logger;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'bar:hello',
    description: 'Bar test command'
)]
class BarHelloCommand extends Command
{
    public function __construct(string $name = null, private readonly Logger $logger)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Hello from Bar!');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $message = 'Hello from Bar!';
        $output->writeln($message);
        $this->logger->info($message);

        return Command::SUCCESS;
    }
}
