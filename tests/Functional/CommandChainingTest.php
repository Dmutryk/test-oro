<?php

namespace Tests\Functional;

use BarBundle\Command\BarHelloCommand;
use ChainCommandBundle\CommandChainRegistry;
use ChainCommandBundle\EventListener\CommandChainListener;
use ChainCommandBundle\Exception\WrongChainCommandCallException;
use FooBundle\Command\FooHelloCommand;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Bundle\FrameworkBundle\Console\Application as FrameworkApplication;

class CommandChainingTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::$kernel = static::createKernel();
        self::$kernel->boot();
    }

    /** @test */
    public function testCommandChainingSuccess()
    {
        $registry = new CommandChainRegistry();
        $logger = new Logger('test');

        $listener = new CommandChainListener($registry, $logger);
        $dispatcher = self::getContainer()->get('event_dispatcher');
        $dispatcher->addSubscriber($listener);

        $application = new FrameworkApplication(self::$kernel);
        $application->addCommands([
            new FooHelloCommand($logger),
            new BarHelloCommand($logger),
        ]);

        $input = new ArrayInput(['command' => 'foo:hello']);
        $output = new BufferedOutput();
        $application->doRun($input, $output);

        $outputContent = $output->fetch();
        
        $this->assertStringContainsString(FooHelloCommand::MESSAGE, $outputContent);
        $this->assertStringContainsString(BarHelloCommand::MESSAGE, $outputContent);
  }

    /** @test */
    public function testCommandChainingFailScenario()
    {
        $registry = new CommandChainRegistry();
        $logger = new Logger('test');

        $listener = new CommandChainListener($registry, $logger);
        $dispatcher = self::getContainer()->get('event_dispatcher');
        $dispatcher->addSubscriber($listener);

        $application = new FrameworkApplication(self::$kernel);
        $application->addCommands([
            new FooHelloCommand($logger),
            new BarHelloCommand($logger),
        ]);

        $this->expectException(WrongChainCommandCallException::class);
        
        $input = new ArrayInput(['command' => 'bar:hello']);
        $output = new BufferedOutput();
        $application->doRun($input, $output);
    }
}

