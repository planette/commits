<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 *
 * @ORM\Table(indexes = {
 *     @ORM\Index(columns = {"committed_at"}),
 * })
 */
class Commit
{

	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity = "Repository", inversedBy = "commits")
	 * @ORM\JoinColumn(name = "repository", referencedColumnName = "id", onDelete = "CASCADE")
	 */
	private Repository $repository;

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string")
	 */
	private string $sha;

	/**
	 * @ORM\ManyToOne(targetEntity = "User")
	 * @ORM\JoinColumn(name = "author", onDelete = "SET NULL")
	 */
	private ?User $author;

	/** @ORM\Column(type = "string") */
	private string $authorName;

	/** @ORM\Column(type = "datetime_immutable") */
	private \DateTimeImmutable $authoredAt;

	/**
	 * @ORM\ManyToOne(targetEntity = "User")
	 * @ORM\JoinColumn(name = "committer", onDelete = "SET NULL")
	 */
	private ?User $committer;

	/** @ORM\Column(type = "string") */
	private string $committerName;

	/** @ORM\Column(type = "datetime_immutable") */
	private \DateTimeImmutable $committedAt;

	/** @ORM\Column(type = "text") */
	private string $message;

	/** @ORM\Column(type = "integer") */
	private int $additions;

	/** @ORM\Column(type = "integer") */
	private int $deletions;

	/** @ORM\Column(type = "integer") */
	private int $total;

	/**
	 * @ORM\OneToMany(targetEntity = "CommitFile", mappedBy = "commit", cascade = {"persist"})
	 * @ORM\OrderBy({"filename" = "ASC"})
	 * @var CommitFile[]|Collection<int, CommitFile>
	 */
	private Collection $files;


	public function __construct(
		Repository $repository,
		string $sha,
		?User $author,
		string $authorName,
		\DateTimeImmutable $authoredAt,
		?User $committer,
		string $committerName,
		\DateTimeImmutable $committedAt,
		string $message,
		int $additions,
		int $deletions,
		int $total

	) {
		$this->sha = $sha;
		$repository->addCommit($this);
		$this->repository = $repository;

		$this->author = $author;
		$this->authoredAt = $authoredAt;
		$this->authorName = $authorName;

		$this->committer = $committer;
		$this->committedAt = $committedAt;
		$this->committerName = $committerName;

		$this->total = $total;
		$this->author = $author;
		$this->message = $message;

		$this->total = $total;
		$this->additions = $additions;
		$this->committer = $committer;
		$this->deletions = $deletions;

		$this->files = new ArrayCollection;
	}


	public function addFile(CommitFile $file): self
	{
		if (!$this->files->contains($file)) {
			$this->files->add($file);
		}

		return $this;
	}

}
