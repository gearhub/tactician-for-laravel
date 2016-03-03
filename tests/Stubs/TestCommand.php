<?php

namespace GearHub\Tactician\Tests\Stubs;

class TestCommand
{
	public $data;

	function __construct($data)
	{
		$this->data = $data;
	}
}
