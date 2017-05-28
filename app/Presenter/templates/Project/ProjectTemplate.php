<?php

declare(strict_types = 1);

namespace App\Presenter;

use App\Entity\Project;
use App\View\DefaultTemplate;


final class ProjectTemplate extends DefaultTemplate
{

	public Project $project;

}
