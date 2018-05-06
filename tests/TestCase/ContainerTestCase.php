<?php

declare(strict_types = 1);

namespace Tests\TestCase;

use App\Bootstrap;
use Nette\DI\Container;


abstract class ContainerTestCase extends PHPStanTestCase
{

	protected Container $container;


	protected function setUp(): void
	{
		parent::setUp();

		$this->container = Bootstrap::boot()->createContainer();
	}

}
