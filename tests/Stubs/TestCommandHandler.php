<?php

namespace GearHub\Tactician\Tests\Stubs;

use GearHub\Tactician\Tests\Stubs\TestCommand;

class TestCommandHandler
{
	public function handle(TestCommand $command)
	{
		return $command->data;
	}
}
