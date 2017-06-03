<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/** @ORM\Entity */
class CommitFile
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string")
	 */
	private string $id;

	/**
	 * @ORM\ManyToOne(targetEntity = "Commit", inversedBy = "files")
	 * @ORM\JoinColumns({
	 *     @ORM\JoinColumn(name = "commit_repository", referencedColumnName = "repository", nullable = false, onDelete = "CASCADE"),
	 *     @ORM\JoinColumn(name = "commit_sha", referencedColumnName = "sha", nullable = false, onDelete = "CASCADE")
	 * })
	 */
	private Commit $commit;

	/** @ORM\Column(type = "string") */
	private string $filename;

	/** @ORM\Column(type = "string") */
	private string $status;

	/** @ORM\Column(type = "integer") */
	private int $additions;

	/** @ORM\Column(type = "integer") */
	private int $deletions;

	/** @ORM\Column(type = "integer") */
	private int $changes;


	private const STATUS_ADDED = 'added';
	private const STATUS_MODIFIED = 'modified';
	private const STATUS_RENAMED = 'renamed';
	private const STATUS_REMOVED = 'removed';


	public function __construct(
		Commit $commit,
		string $filename,
		string $status,
		int $additions,
		int $deletions,
		int $changes

	) {
		$commit->addFile($this);
		$this->commit = $commit;

		$this->status = $status;
		$this->changes = $changes;
		$this->id = ID::generate();
		$this->filename = $filename;
		$this->additions = $additions;
		$this->deletions = $deletions;
	}


	public function getFilename(): string
	{
		return $this->filename;
	}


	public function getAdditions(): int
	{
		return $this->additions;
	}


	public function getDeletions(): int
	{
		return $this->deletions;
	}

}
