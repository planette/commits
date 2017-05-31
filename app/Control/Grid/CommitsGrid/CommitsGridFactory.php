<?php

declare(strict_types = 1);

namespace App\Control\Grid\CommitsGrid;

use App\Entity\Project;


interface CommitsGridFactory
{

	public function create(Project $project): CommitsGrid;

}
