<?php

declare(strict_types = 1);

namespace App\QueryFunction\Commit;

use Doctrine\DBAL\Connection;


final class CommitsRepositoryShaMapQuery
{

	private Connection $connection;


	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}


	/** @return array<string, array<string, int>> */
	public function get(): array
	{
		$rows = $this->connection->fetchAllAssociative('
				SELECT r.id, c.sha, c.sort
				FROM `commit` c
				JOIN repository r ON c.repository = r.id
				ORDER BY c.sort ASC
			');

		$shaMap = [];
		foreach ($rows as $row) {
			$sID = (string) $row['id'];

			if (!isset($shaMap[$sID])) {
				$shaMap[$sID] = [];
			}

			$shaMap[$sID][(string) $row['sha']] = (int) $row['sort'];
		}

		return $shaMap;
	}

}
