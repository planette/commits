<?php

declare(strict_types = 1);

namespace App\Entity;


class CommitFile
{

	private string $id;
	private Commit $commit;
	private string $filename;
	private string $status;
	private int $additions;
	private int $deletions;
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

}
