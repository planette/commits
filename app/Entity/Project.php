<?php

declare(strict_types = 1);

namespace App\Entity;

use Nette\Utils\Arrays;


class Project
{

	private string $id;
	private string $name;

	/** @var Repository[] */
	private array $repositories;


	public function __construct(string $name)
	{
		$this->name = $name;
		$this->id = ID::generate();
	}


	public function addRepository(Repository $repository): self
	{
		if (!Arrays::contains($this->repositories, $repository)) {
			$this->repositories[] = $repository;
		}

		return $this;
	}

}
