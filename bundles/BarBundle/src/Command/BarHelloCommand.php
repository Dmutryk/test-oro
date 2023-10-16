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
    public const MESSAGE = 'Hello from Bar!';
    
    public function __construct(private readonly Logger $logger, string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription(self::MESSAGE);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(self::MESSAGE);
        $this->logger->info(self::MESSAGE);

        return Command::SUCCESS;
    }
}
