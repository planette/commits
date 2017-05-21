<?php

declare(strict_types = 1);

use Nette\Application\Application;

require __DIR__ . '/../vendor/autoload.php';

/** @var Application $application */
$application = App\Bootstrap::boot()
	->createContainer()
	->getByType(Application::class);

$application->run();
