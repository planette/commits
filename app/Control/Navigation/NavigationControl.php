<?php

declare(strict_types = 1);

namespace App\Control\Navigation;

use Nette\Application\UI\Control;
use App\QueryFunction\Project\ProjectsSortedQuery;


final class NavigationControl extends Control
{

	private ProjectsSortedQuery $projectsQuery;


	public function __construct(ProjectsSortedQuery $projectsQuery)
	{
		$this->projectsQuery = $projectsQuery;
	}


	public function render(): void
	{
		/** @var NavigationTemplate $template */
		$template = $this->createTemplate(NavigationTemplate::class);

		$template->setFile(__DIR__ . '/NavigationControl.latte');
		$template->projects = $this->projectsQuery->get();
		$template->render();
	}

}
