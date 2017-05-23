<?php

declare(strict_types = 1);

namespace App\Entity\Synchronization;

use App\Entity\ID;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(indexes = {
 *     @ORM\Index(columns = {"started_at"}),
 *     @ORM\Index(columns = {"finished_at"})
 * })
 */
class SynchronizationLog
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string")
	 */
	private string $id;

	/** @ORM\Column(type = "datetime_immutable") */
	private \DateTimeImmutable $startedAt;

	/** @ORM\Column(type = "datetime_immutable", nullable = true) */
	private ?\DateTimeImmutable $finishedAt;

	/** @ORM\Column(type = "integer", nullable = true) */
	private ?int $memoryPeak;

	/**
	 * @ORM\OneToMany(targetEntity = "RepositoryLog", mappedBy = "synchronizationLog", cascade = {"persist"})
	 * @ORM\JoinColumn(onDelete = "CASCADE")
	 * @var RepositoryLog[]|Collection<int, RepositoryLog>
	 */
	private Collection $repositoryLogs;


	public function __construct()
	{
		$this->id = ID::generate();
		$this->startedAt = new \DateTimeImmutable;
		$this->repositoryLogs = new ArrayCollection;
	}


	public function addRepositoryLog(RepositoryLog $repositoryLog): self
	{
		if (!$this->repositoryLogs->contains($repositoryLog)) {
			$this->repositoryLogs->add($repositoryLog);
		}

		return $this;
	}


	public function getStartedAt(): \DateTimeImmutable
	{
		return $this->startedAt;
	}


	public function finish(): void
	{
		$this->memoryPeak = memory_get_peak_usage(true);
		$this->finishedAt = new \DateTimeImmutable;
	}


	public function getApiCalls(): int
	{
		return array_sum(array_map(static function (RepositoryLog $repositoryLog): int {
			return $repositoryLog->getApiCalls();

		}, $this->repositoryLogs->toArray()));
	}


	public function getNewCommits(): int
	{
		return array_sum(array_map(static function (RepositoryLog $repositoryLog): int {
			return $repositoryLog->getNewCommits();

		}, $this->repositoryLogs->toArray()));
	}


	public function getDeletedCommits(): int
	{
		return array_sum(array_map(static function (RepositoryLog $repositoryLog): int {
			return $repositoryLog->getDeletedCommits();

		}, $this->repositoryLogs->toArray()));
	}


	public function getMemoryPeak(): ?int
	{
		return $this->memoryPeak;
	}


	public function getElapsedSeconds(): int
	{
		return ($this->finishedAt === null ? time() : $this->finishedAt->getTimestamp())
			- $this->startedAt->getTimestamp();
	}

}
