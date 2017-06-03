<?php

declare(strict_types = 1);

namespace App\Presenter;

use App\Entity\Commit;
use App\Entity\Project;
use App\View\DefaultTemplate;


final class ProjectRssTemplate extends DefaultTemplate
{

	public Project $project;

	/** @var Commit[] */
	public array $commits;

}
