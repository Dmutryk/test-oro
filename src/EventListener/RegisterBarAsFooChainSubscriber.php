<?php

namespace App\EventListener;

use FooBundle\Command\FooHelloCommand;
use BarBundle\Command\BarHelloCommand;
use ChainCommandBundle\CommandChainRegistry;
use Monolog\Logger;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RegisterBarAsFooChainSubscriber implements EventSubscriberInterface
{

    public function __construct(
        //Maybe create interface. For test purpose concrete class should be ok.
        private readonly CommandChainRegistry $commandChainRegistry,
        private readonly Logger $logger,
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::class => 'onConsoleCommand',
        ];
    }

    public function onConsoleCommand(ConsoleCommandEvent $event)
    {
        $this->logger->info(sprintf(
            '%s is a master command of a command chain that has registered member commands',
            FooHelloCommand::getDefaultName()
        ));
        $this->logger->info(sprintf(
            '%s registered as a member of %s command chain',
            FooHelloCommand::getDefaultName(),
            BarHelloCommand::getDefaultName(),
        ));
        $this->commandChainRegistry->registerCommandChain(
            FooHelloCommand::getDefaultName(),
            [BarHelloCommand::getDefaultName()]
        );
    }
}
