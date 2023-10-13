<?php

namespace ChainCommandBundle\Tests\Unit;

use ChainCommandBundle\EventListener\CommandChainListener;
use ChainCommandBundle\CommandChainRegistry;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\EventDispatcher\EventDispatcher;

class CommandChainListenerTest extends TestCase
{
    public function testOnConsoleCommandEventListener()
    {
        $dispatcher = new EventDispatcher();

        $registry = $this->createMock(CommandChainRegistry::class);
        $logger = $this->createMock(Logger::class);
        $command = $this->createMock(Command::class);
        $command->method('getName')->willReturn('command');
        $listener = new CommandChainListener($registry, $logger);
        $dispatcher->addListener('onConsoleCommand', [$listener, 'onConsoleCommand']);

        // dispatch your event here
        $input = new ArrayInput([]);
        $output = new BufferedOutput();
        $event = new ConsoleCommandEvent($command, $input, $output);
        $dispatcher->dispatch($event, 'onConsoleCommand');

        $this->assertArrayHasKey(CommandChainListener::class, $dispatcher->getListeners());
    }
}

