<?php

declare(strict_types = 1);

namespace Tests\TestCase;

use Tester\TestCase;


abstract class PHPStanTestCase extends TestCase
{

	public function run(): void
	{
		if (!defined('__PHPSTAN_RUNNING__')) {
			parent::run();
		}
	}

}
