<?php

declare(strict_types = 1);

namespace App\Presenter;

use Nette\Application\UI\Presenter;
use App\QueryFunction\Project\ProjectBySlugQuery;
use App\QueryFunction\Project\ProjectNotFoundException;
use App\QueryFunction\Commit\CommitsLatestByProjectWithFilesQuery;


/** @property ProjectRssTemplate $template */
final class ProjectRssPresenter extends Presenter
{

	private ProjectBySlugQuery $projectBySlugQuery;
	private CommitsLatestByProjectWithFilesQuery $commitsQuery;


	public function __construct(ProjectBySlugQuery $projectBySlugQuery, CommitsLatestByProjectWithFilesQuery $commitsQuery)
	{
		parent::__construct();

		$this->commitsQuery = $commitsQuery;
		$this->projectBySlugQuery = $projectBySlugQuery;
	}


	public function renderFeed(string $projectSlug): void
	{
		try {
			$project = $this->projectBySlugQuery->get($projectSlug);

			$this->template->project = $project;
			$this->template->commits = $this->commitsQuery->get($project, 60);

		} catch (ProjectNotFoundException $e) {
			$this->error($e->getMessage());
		}
	}

}
