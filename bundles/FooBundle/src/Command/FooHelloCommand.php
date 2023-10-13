<?php

declare(strict_types=1);

namespace FooBundle\Command;

use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'foo:hello',
    description: 'Foo test command'
)]
class FooHelloCommand extends Command
{
    public function __construct(string $name = null, private readonly Logger $logger)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Hello from Foo!');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $message = 'Hello from Foo!';
        $output->writeln($message);
        $this->logger->info($message);

        return Command::SUCCESS;
    }
}
