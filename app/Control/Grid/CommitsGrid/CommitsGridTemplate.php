<?php

declare(strict_types = 1);

namespace App\Control\Grid\CommitsGrid;

use App\Entity\Project;
use App\View\DefaultTemplate;


final class CommitsGridTemplate extends DefaultTemplate
{

	public Project $project;

}
