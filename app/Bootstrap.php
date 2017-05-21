<?php

declare(strict_types = 1);

namespace App;

use Nette\Configurator;


class Bootstrap
{

	public static function boot(): Configurator
	{
		$appDir = dirname(__DIR__);
		$configurator = new Configurator;

		$configurator->setDebugMode(PHP_SAPI === 'cli' ? true : []);
		$configurator->enableTracy($appDir . '/log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory($appDir . '/temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator->addConfig($appDir . '/config/common.neon');
		$configurator->addConfig($appDir . '/config/local.neon');

		return $configurator;
	}

}
