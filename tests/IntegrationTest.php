<?php

namespace GearHub\Tactician\Tests;

use GearHub\Tactician\Dispatcher;
use GearHub\Tactician\Locator;
use GearHub\Tactician\Tests\Stubs\TestCommand;
use GearHub\Tactician\Tests\Stubs\TestCommandHandler;
use GearHub\Tactician\Tests\Stubs\TestWithDefaultCommand;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use Mockery;
use PHPUnit_Framework_TestCase;

class IntegrationTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
        $this->container         = Mockery::mock(Container::class);
        $this->locator           = new Locator($this->container, 'GearHub\Tactician\Tests\Stubs', 'GearHub\Tactician\Tests\Stubs');
        $this->handlerMiddleware = new CommandHandlerMiddleware(new ClassNameExtractor(), $this->locator, new HandleInflector());
        $this->commandbus        = new CommandBus([$this->handlerMiddleware]);
        $this->dispatcher        = new Dispatcher($this->commandbus);
	}

	public function tearDown()
	{
		Mockery::close();
	}

	/**
	 * @test
	 */
	public function it_should_handle_the_command_successfully_using_dispatch()
	{
		$this->container->shouldReceive('make')->andReturn(new TestCommandHandler);

		$command = new TestCommand('foo');
		$result  = $this->dispatcher->dispatch($command);

		$this->assertEquals($result, 'foo');
	}

	/**
	 * @test
	 */
	public function it_should_handle_the_command_successfully_using_dispatch_from_with_no_extras()
	{
		$this->container->shouldReceive('make')->andReturn(new TestCommandHandler);

		$collection = new Collection(['data' => 'foo']);
		$result     = $this->dispatcher->dispatchFrom(TestCommand::class, $collection);

		$this->assertEquals($result, 'foo');
	}

	/**
	 * @test
	 */
	public function it_should_handle_the_command_successfully_using_dispatch_from_with_extras()
	{
		$this->container->shouldReceive('make')->andReturn(new TestCommandHandler);

		$collection = new Collection(['data' => 'foo']);
		$result     = $this->dispatcher->dispatchFrom(TestCommand::class, $collection, ['data' => 'bar']);

		$this->assertEquals($result, 'bar');
	}

	/**
	 * @test
	 * @expectedException \League\Tactician\Exception\MissingHandlerException
	 */
	public function it_should_not_handle_the_command_successfully_using_dispatch()
	{
		$this->container->shouldReceive('make')->never();

		$command = new TestWithDefaultCommand('foo');
		$result  = $this->dispatcher->dispatch($command);

		$this->assertEquals($result, 'foo');
	}

	/**
	 * @test
	 * @expectedException \GearHub\Tactician\Exceptions\MarshalException
	 */
	public function it_should_fail_building_the_command()
	{
		$collection = new Collection(['foo' => 'bar']);
		$command    = $this->dispatcher->dispatchFrom(TestCommand::class, $collection);
	}

}
