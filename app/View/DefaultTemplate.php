<?php

declare(strict_types = 1);

namespace App\View;

use Nette\Security\User;
use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\Template;


class DefaultTemplate extends Template
{

	public Presenter $presenter;
	public Control $control;
	public User $user;
	public string $baseUrl;
	public string $basePath;

	/** @var \stdClass[] */
	public array $flashes = [];

}
