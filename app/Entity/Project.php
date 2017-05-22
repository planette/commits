<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/** @ORM\Entity */
class Project
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string")
	 */
	private string $id;

	/** @ORM\Column(type = "string", unique = true) */
	private string $name;

	/**
	 * @ORM\OneToMany(targetEntity = "Repository", mappedBy = "project")
	 * @ORM\OrderBy({"name" = "ASC"})
	 * @var Repository[]|Collection<int, Repository>
	 */
	private Collection $repositories;


	public function __construct(string $name)
	{
		$this->name = $name;
		$this->id = ID::generate();
		$this->repositories = new ArrayCollection;
	}


	public function addRepository(Repository $repository): self
	{
		if (!$this->repositories->contains($repository)) {
			$this->repositories->add($repository);
		}

		return $this;
	}

}
