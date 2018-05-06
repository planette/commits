<?php

declare(strict_types = 1);

namespace Tests;

use Tester\Environment;
use Nette\Loaders\RobotLoader;


require_once __DIR__ . '/../vendor/autoload.php';


if (!defined('__PHPSTAN_RUNNING__')) {
	Environment::setup();
	date_default_timezone_set('Europe/Prague');

	(new RobotLoader)
		->addDirectory(__DIR__)
		->setTempDirectory(__DIR__ . '/../var/temp')
		->register();
}
