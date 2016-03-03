<?php

namespace GearHub\Tactician\Tests\Stubs;

use GearHub\Tactician\Dispatcher;

class TestDispatcher extends Dispatcher
{
	public function __call($method, $args)
	{
		return call_user_func_array([$this, $method], $args);
	}

	public function __get($key)
	{
		return $this->$key;
	}
}
