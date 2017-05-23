<?php

declare(strict_types = 1);

namespace App\Entity\Synchronization;

use App\Entity\ID;
use App\Entity\Repository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(indexes = {
 *     @ORM\Index(columns = {"started_at"}),
 *     @ORM\Index(columns = {"finished_at"})
 * })
 */
class RepositoryLog
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string")
	 */
	private string $id;

	/**
	 * @ORM\ManyToOne(targetEntity = "SynchronizationLog", inversedBy = "repositoryLogs")
	 * @ORM\JoinColumn(nullable = false, onDelete = "CASCADE")
	 */
	private SynchronizationLog $synchronizationLog;

	/**
	 * @ORM\ManyToOne(targetEntity = "App\Entity\Repository")
	 * @ORM\JoinColumn(name = "repository", referencedColumnName = "id", nullable = false, onDelete = "CASCADE")
	 */
	private Repository $repository;

	/** @ORM\Column(type = "datetime_immutable") */
	private \DateTimeImmutable $startedAt;

	/** @ORM\Column(type = "datetime_immutable", nullable = true) */
	private ?\DateTimeImmutable $finishedAt;

	/** @ORM\Column(type = "integer") */
	private int $apiCalls = 0;

	/** @ORM\Column(type = "integer") */
	private int $newCommits = 0;

	/** @ORM\Column(type = "integer") */
	private int $deletedCommits = 0;

	/** @ORM\Column(type = "integer") */
	private int $newUsers = 0;


	public function __construct(SynchronizationLog $synchronizationLog, Repository $repository)
	{
		$this->id = ID::generate();
		$this->repository = $repository;
		$this->startedAt = new \DateTimeImmutable;
		$this->synchronizationLog = $synchronizationLog;

		$synchronizationLog->addRepositoryLog($this);
	}


	public function apiCall(): void
	{
		$this->apiCalls++;
	}


	public function getApiCalls(): int
	{
		return $this->apiCalls;
	}


	public function newCommit(): void
	{
		$this->newCommits++;
	}


	public function getNewCommits(): int
	{
		return $this->newCommits;
	}


	public function deletedCommits(int $count): void
	{
		$this->deletedCommits = $count;
	}


	public function getDeletedCommits(): int
	{
		return $this->deletedCommits;
	}


	public function newUser(): void
	{
		$this->newUsers++;
	}


	public function finish(): void
	{
		$this->finishedAt = new \DateTimeImmutable;
	}

}
