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
 *     @ORM\Index(columns = {"sort"}),
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

	/** @ORM\Column(type = "integer") */
	private int $sort;

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
		int $total,
		int $sort = 0

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

		$this->sort = $sort;

		$this->files = new ArrayCollection;
	}


	public function getRepository(): Repository
	{
		return $this->repository;
	}


	public function getSha(): string
	{
		return $this->sha;
	}


	public function hasAuthor(): bool
	{
		return $this->author !== null;
	}


	public function getAuthor(): ?User
	{
		return $this->author;
	}


	public function getAuthorName(): string
	{
		return $this->authorName;
	}


	public function hasCommitter(): bool
	{
		return $this->committer !== null;
	}


	public function getCommitter(): ?User
	{
		return $this->committer;
	}


	public function getCommitterName(): string
	{
		return $this->committerName;
	}


	public function getCommittedAt(): \DateTimeImmutable
	{
		return $this->committedAt;
	}


	public function hasDifferentAuthorAndCommitter(): bool
	{
		return $this->author !== $this->committer;
	}


	public function getURL(): string
	{
		return sprintf('https://github.com/%s/commit/%s', $this->repository->getName(), $this->sha);
	}


	public function getMessage(): string
	{
		return $this->message;
	}


	public function getFirstMessageLine(): string
	{
		$firstEOL = strpos($this->message, "\n");
		return $firstEOL === false ? $this->message : substr($this->message, 0, $firstEOL);
	}


	public function addFile(CommitFile $file): self
	{
		if (!$this->files->contains($file)) {
			$this->files->add($file);
		}

		return $this;
	}

}
