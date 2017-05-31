<?php

declare(strict_types = 1);

namespace App\QueryFunction\Project;


final class ProjectNotFoundException extends \Exception
{

	public static function bySlug(string $slug): ProjectNotFoundException
	{
		return new self(sprintf('Project with slug "%s" not found.', $slug));
	}

}
