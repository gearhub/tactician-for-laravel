<?php

namespace GearHub\Tactician\Tests;

use Mockery;
use PHPUnit_Framework_TestCase;

use Illuminate\Contracts\Container\Container;

use GearHub\Tactician\Tests\Stubs\TestLocator;
use GearHub\Tactician\Tests\Stubs\TestCommand;
use GearHub\Tactician\Tests\Stubs\TestWithDefaultCommand;
use GearHub\Tactician\Tests\Stubs\TestCommandHandler;

class LocatorTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->container = Mockery::mock(Container::class);
		$this->locator   = new TestLocator($this->container, 'GearHub\Tactician\Tests\Stubs', 'GearHub\Tactician\Tests\Stubs');
	}

	public function tearDown()
	{
		Mockery::close();
	}

	/**
	 * @test
	 */
	public function it_should_contain_the_correct_namespaces()
	{
		$this->assertEquals($this->locator->command_namespace, 'GearHub\Tactician\Tests\Stubs');
		$this->assertEquals($this->locator->handler_namespace, 'GearHub\Tactician\Tests\Stubs');
	}

	/**
	 * @test
	 */
	public function it_should_return_the_correct_handler()
	{
		$this->container->shouldReceive('make')->andReturn(new TestCommandHandler);

		$handler = $this->locator->getHandlerForCommand(TestCommand::class);

		$this->assertInstanceOf(TestCommandHandler::class, $handler);
	}

	/**
	 * @test
	 * @expectedException \League\Tactician\Exception\MissingHandlerException
	 */
	public function it_should_not_find_the_correct_handler()
	{
		$this->container->shouldReceive('make')->never();

		$handler = $this->locator->getHandlerForCommand(TestWithDefaultCommand::class);
	}

}
