<?php

declare(strict_types = 1);

namespace App\Entity;

use Nette\Utils\Arrays;


class Commit
{

	private Repository $repository;
	private string $sha;
	private ?User $author;
	private string $authorName;
	private \DateTimeImmutable $authoredAt;
	private ?User $committer;
	private string $committerName;
	private \DateTimeImmutable $committedAt;
	private string $message;
	private int $additions;
	private int $deletions;
	private int $total;

	/** @var CommitFile[] */
	private array $files;


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
		$repository->addCommit($this);
		$this->repository = $repository;

		$this->sha = $sha;
		$this->total = $total;
		$this->author = $author;
		$this->message = $message;
		$this->additions = $additions;
		$this->committer = $committer;
		$this->deletions = $deletions;
		$this->authorName = $authorName;
		$this->authoredAt = $authoredAt;
		$this->committedAt = $committedAt;
		$this->committerName = $committerName;
	}


	public function addFile(CommitFile $file): self
	{
		if (!Arrays::contains($this->files, $file)) {
			$this->files[] = $file;
		}

		return $this;
	}

}
