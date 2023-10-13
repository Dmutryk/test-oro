<?php

namespace ChainCommandBundle\Tests\Unit;

use BarBundle\Command\BarHelloCommand;
use ChainCommandBundle\Command\ChainCommand;
use ChainCommandBundle\CommandChainRegistry;
use FooBundle\Command\FooHelloCommand;
use PHPUnit\Framework\TestCase;

/** FooHelloCommand and BarHelloCommand should be here, but I used them to speed up test task implementation */
class CommandChainRegistryTest extends TestCase
{
    public function testRegisterCommandChain()
    {
        // Create an instance of CommandChainRegistry
        $registry = new CommandChainRegistry();

        // Register a command chain
        $registry->registerCommandChain(FooHelloCommand::getDefaultName(), [BarHelloCommand::getDefaultName()]);

        // Assert that the command chain is registered correctly
        $this->assertTrue($registry->isCommandInChain(BarHelloCommand::getDefaultName()));
        $this->assertEquals([BarHelloCommand::getDefaultName()], $registry->getChainedCommands(FooHelloCommand::getDefaultName()));
    }

    public function testIsCommandInChain()
    {
        // Create an instance of CommandChainRegistry
        $registry = new CommandChainRegistry();

        // Register a command chain
        $registry->registerCommandChain(FooHelloCommand::getDefaultName(), [BarHelloCommand::getDefaultName()]);

        // Check if a command is in the chain
        $this->assertTrue($registry->isCommandInChain(BarHelloCommand::getDefaultName()));
        $this->assertFalse($registry->isCommandInChain(ChainCommand::getDefaultName()));
    }

    public function testGetChainedCommands()
    {
        // Create an instance of CommandChainRegistry
        $registry = new CommandChainRegistry();

        // Register a command chain
        $registry->registerCommandChain(FooHelloCommand::getDefaultName(), [BarHelloCommand::getDefaultName()]);

        // Get the chained commands
        $this->assertEquals([BarHelloCommand::getDefaultName()], $registry->getChainedCommands(FooHelloCommand::getDefaultName()));
        $this->assertEquals([], $registry->getChainedCommands(ChainCommand::getDefaultName()));
    }
}
