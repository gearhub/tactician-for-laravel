<?php

namespace GearHub\Tactician\Tests\Stubs;

use GearHub\Tactician\Locator;

class TestLocator extends Locator
{
	public function __get($key)
	{
		return $this->$key;
	}
}
