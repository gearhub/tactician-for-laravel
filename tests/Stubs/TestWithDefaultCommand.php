<?php

namespace GearHub\Tactician\Tests\Stubs;

class TestWithDefaultCommand
{
	public $data;

	function __construct($data = null)
	{
		$this->data = $data;
	}
}
