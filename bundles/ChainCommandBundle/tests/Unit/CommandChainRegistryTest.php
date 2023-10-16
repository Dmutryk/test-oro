<?php

namespace ChainCommandBundle\Tests\Unit;

use BarBundle\Command\BarHelloCommand;
use ChainCommandBundle\Command\ChainCommand;
use ChainCommandBundle\CommandChainRegistry;
use FooBundle\Command\FooHelloCommand;
use PHPUnit\Framework\TestCase;

/** FooHelloCommand and BarHelloCommand should not be here, but I used them to speed up test task implementation */
class CommandChainRegistryTest extends TestCase
{
    public function testRegisterCommandChain()
    {
        $registry = new CommandChainRegistry();
        $masterCommand = $this->createMock(ChainCommand::class);
        $masterCommand->method('getName')->willReturn('master:hello');
        $chainedCommand = $this->createMock(ChainCommand::class);
        $chainedCommand->method('getName')->willReturn('chained:hello');

        $registry->registerCommandChain($masterCommand->getName(), [$chainedCommand->getName()]);
        
        $this->assertTrue($registry->isCommandInChain($masterCommand->getName()));
        $this->assertEquals([$chainedCommand->getName()], $registry->getChainedCommands($masterCommand->getName()));
    }

    public function testIsCommandChained()
    {
        $registry = new CommandChainRegistry();
        $registry->registerCommandChain(FooHelloCommand::getDefaultName(), [BarHelloCommand::getDefaultName()]);
        
        $this->assertNotNull($registry->isCommandChained(BarHelloCommand::getDefaultName()));
        $this->assertNull($registry->isCommandChained(ChainCommand::getDefaultName()));
    }

    public function testGetChainedCommands()
    {
        $registry = new CommandChainRegistry();
        $registry->registerCommandChain(FooHelloCommand::getDefaultName(), [BarHelloCommand::getDefaultName()]);

        $this->assertEquals([BarHelloCommand::getDefaultName()], $registry->getChainedCommands(FooHelloCommand::getDefaultName()));
        $this->assertEquals([], $registry->getChainedCommands(ChainCommand::getDefaultName()));
    }
}
