<?php

declare(strict_types = 1);

namespace App\Router;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use App\QueryFunction\Project\ProjectsSortedQuery;
use Doctrine\DBAL\Exception\TableNotFoundException;


final class RouterFactory
{

	private ProjectsSortedQuery $projectsQuery;


	public function __construct(ProjectsSortedQuery $projectsQuery)
	{
		$this->projectsQuery = $projectsQuery;
	}


	public function createRouter(): RouteList
	{
		$router = new RouteList;

		try {
			$projectSlugs = [];
			foreach ($this->projectsQuery->get() as $project) {
				$projectSlugs[] = $project->getSlug();
			}

			if (count($projectSlugs) === 0) {
				$router[] = new Route('', static function (): void {
					echo 'ERROR: No project found. Did you run fixtures?';
					exit(1);
				});

			} else {
				$projectMask = '<projectSlug=' . reset($projectSlugs) . ' ' . implode('|', $projectSlugs) . '>';
				$router[] = new Route('rss/' . $projectMask, 'ProjectRss:feed');
				$router[] = new Route($projectMask, 'Project:commits');
			}

			return $router;

		} catch (TableNotFoundException $e) {} // schema may not exist yet

		throw new \LogicException('Database schema does not exist. Have you created it?');
	}

}
