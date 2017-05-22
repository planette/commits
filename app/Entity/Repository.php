<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/** @ORM\Entity */
class Repository
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string")
	 */
	private string $id;

	/**
	 * @ORM\ManyToOne(targetEntity = "Project", inversedBy = "repositories")
	 * @ORM\JoinColumn(nullable = false, onDelete = "CASCADE")
	 */
	private Project $project;

	/** @ORM\Column(type = "string", unique = true) */
	private string $name;

	/**
	 * @ORM\OneToMany(targetEntity = "Commit", mappedBy = "repository")
	 * @ORM\OrderBy({"committedAt" = "DESC"})
	 * @var Commit[]|Collection<int, Commit>
	 */
	private Collection $commits;


	public function __construct(Project $project, string $name)
	{
		$this->project = $project;
		$project->addRepository($this);

		$this->name = $name;
		$this->id = ID::generate();
		$this->commits = new ArrayCollection;
	}


	public function addCommit(Commit $commit): self
	{
		if (!$this->commits->contains($commit)) {
			$this->commits->add($commit);
		}

		return $this;
	}

}
