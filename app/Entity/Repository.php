<?php

declare(strict_types = 1);

namespace App\Entity;

use Nette\Utils\Arrays;


class Repository
{

	private string $id;
	private Project $project;
	private string $name;

	/** @var Commit[] */
	private array $commits;


	public function __construct(Project $project, string $name)
	{
		$this->project = $project;
		$project->addRepository($this);

		$this->name = $name;
		$this->id = ID::generate();
	}


	public function addCommit(Commit $commit): self
	{
		if (!Arrays::contains($this->commits, $commit)) {
			$this->commits[] = $commit;
		}

		return $this;
	}

}
