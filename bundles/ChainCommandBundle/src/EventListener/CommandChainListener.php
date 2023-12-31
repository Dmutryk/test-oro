<?php

declare(strict_types=1);

namespace ChainCommandBundle\EventListener;

use ChainCommandBundle\CommandChainRegistry;
use ChainCommandBundle\Exception\WrongChainCommandCallException;
use Monolog\Logger;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandChainListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly CommandChainRegistry $commandChainRegistry,
        private readonly Logger               $logger
    )
    {
    }

    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        $command = $event->getCommand();
        $commandName = $command->getName();
        $output = $event->getOutput();
        $input = $event->getInput();
        if ($this->commandChainRegistry->isCommandInChain($commandName)) {
            $chainedCommands = $this->commandChainRegistry->getChainedCommands($commandName);

            $this->logger->info(sprintf('Executing %s command itself first:', $commandName,));

            $this->executeCommand($command, $input, $output);

            $this->logger->info(sprintf('Executing %s chain members:', $commandName));

            $application = $command->getApplication();
            foreach ($chainedCommands as $chainedCommand) {
                $this->executeCommand($application->find($chainedCommand), $input, $output);
            }

            $this->logger->info(sprintf('Execution of %s chain completed.', $commandName));

            $event->disableCommand();
        } else {
            $masterCommand = $this->commandChainRegistry->isCommandChained($command->getName());
            if (!is_null($masterCommand)) {
                throw new WrongChainCommandCallException($command->getName(), $masterCommand);
            }
        }
    }

    private function executeCommand($command, $input, $output): void
    {
        $command->run($input, $output);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::COMMAND => 'onConsoleCommand',
        ];
    }
}
