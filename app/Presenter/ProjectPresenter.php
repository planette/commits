<?php

declare(strict_types = 1);

namespace App\Presenter;

use App\Entity\Project;
use Nette\Application\UI\Presenter;
use App\Control\Grid\CommitsGrid\CommitsGrid;
use App\Control\Grid\CommitsGrid\CommitsGridFactory;
use App\QueryFunction\Project\ProjectNotFoundException;
use App\QueryFunction\Project\ProjectBySlugWithRepositoriesQuery;


/** @property ProjectTemplate $template */
final class ProjectPresenter extends Presenter
{

	use TPortalPresenter;


	private ProjectBySlugWithRepositoriesQuery $projectBySlugQuery;
	private CommitsGridFactory $gridFactory;
	private Project $project;


	public function __construct(ProjectBySlugWithRepositoriesQuery $projectBySlugQuery, CommitsGridFactory $gridFactory)
	{
		parent::__construct();

		$this->gridFactory = $gridFactory;
		$this->projectBySlugQuery = $projectBySlugQuery;
	}


	public function actionCommits(string $projectSlug): void
	{
		try {
			$this->project = $this->projectBySlugQuery->get($projectSlug);

		} catch (ProjectNotFoundException $e) {
			$this->error($e->getMessage());
		}
	}


	public function renderCommits(string $projectSlug): void
	{
		$this->template->project = $this->project;
	}


	protected function createComponentCommitsGrid(): CommitsGrid
	{
		return $this->gridFactory->create($this->project);
	}

}
