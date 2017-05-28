<?php

declare(strict_types = 1);

namespace App\Control\Navigation;

use App\Entity\Project;
use App\View\DefaultTemplate;


final class NavigationTemplate extends DefaultTemplate
{

	/** @var Project[] */
	public array $projects = [];

}
