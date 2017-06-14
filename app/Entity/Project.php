<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(indexes = {
 *     @ORM\Index(columns = {"sort"}),
 * })
 */
class Project
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string")
	 */
	private string $id;

	/** @ORM\Column(type = "string", unique = true) */
	private string $name;

	/** @ORM\Column(type = "string", unique = true) */
	private string $slug;

	/**
	 * @ORM\OneToMany(targetEntity = "Repository", mappedBy = "project")
	 * @ORM\OrderBy({"name" = "ASC"})
	 * @var Repository[]|Collection<int, Repository>
	 */
	private Collection $repositories;

	/** @ORM\Column(type = "integer") */
	private int $sort;


	public function __construct(string $name, string $slug, int $sort = 0)
	{
		$this->name = $name;
		$this->slug = $slug;
		$this->sort = $sort;
		$this->id = ID::generate();
		$this->repositories = new ArrayCollection;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getSlug(): string
	{
		return $this->slug;
	}


	public function hasMultipleRepositories(): bool
	{
		return count($this->repositories) > 1;
	}


	public function getFirstRepository(): ?Repository
	{
		$first = $this->repositories->first();
		return $first === false ? null : $first;
	}


	/** @return Repository[] */
	public function getRepositories(): array
	{
		return $this->repositories->toArray();
	}


	public function addRepository(Repository $repository): self
	{
		if (!$this->repositories->contains($repository)) {
			$this->repositories->add($repository);
		}

		return $this;
	}

}
