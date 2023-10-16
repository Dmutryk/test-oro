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
    public const MESSAGE = 'Hello from Foo!';
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
