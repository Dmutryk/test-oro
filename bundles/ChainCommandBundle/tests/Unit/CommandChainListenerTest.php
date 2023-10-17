<?php

namespace ChainCommandBundle\Tests\Unit;

use ChainCommandBundle\EventListener\CommandChainListener;
use ChainCommandBundle\CommandChainRegistry;
use ChainCommandBundle\Exception\WrongChainCommandCallException;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class CommandChainListenerTest extends TestCase
{

    public function testOnConsoleCommandEventListener()
    {
        $command = $this->createMock(Command::class);
        $command->method('getName')->willReturn('command');
        $event = new ConsoleCommandEvent($command, new ArrayInput([]), new BufferedOutput());
        $commandChainRegistry = $this->createMock(CommandChainRegistry::class);
        $logger = $this->createMock(Logger::class);

        $listener = new CommandChainListener($commandChainRegistry, $logger);
        
        $commandChainRegistry->expects($this->once())
            ->method('isCommandInChain')
            ->with('command')
            ->willReturn(true);
        
        $listener->onConsoleCommand($event);
    }
    
    public function testOnConsoleCommandEventListenerThrownException()
    {
        $command = $this->createMock(Command::class);
        $command->method('getName')->willReturn('command');
        $event = new ConsoleCommandEvent($command, new ArrayInput([]), new BufferedOutput());
        $commandChainRegistry = $this->createMock(CommandChainRegistry::class);
        $logger = $this->createMock(Logger::class);

        $listener = new CommandChainListener($commandChainRegistry, $logger);
        
        $commandChainRegistry->expects($this->once())
            ->method('isCommandInChain')
            ->with('command')
            ->willReturn(false);
        
        $commandChainRegistry->expects($this->once())
            ->method('isCommandChained')
            ->with('command')
            ->willReturn('master_command');

        $this->expectException(WrongChainCommandCallException::class);
        
        $listener->onConsoleCommand($event);
    }
}

