<?php

declare(strict_types = 1);

namespace App\Facade\Commit;

use App\Entity\Repository;
use Doctrine\DBAL\Connection;


final class CommitsOrderUpdater
{

	private Connection $connection;


	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}


	/**
	 * Sometimes commits have same author date (due to rebase)
	 * so we need to keep the same order as received from GitHub API
	 *
	 * @param  string[] $allSHAs
	 */
	public function update(Repository $repository, array $allSHAs): void
	{
		if (count($allSHAs) === 0) {
			return ;
		}

		$sortSQL = '
			UPDATE `commit` SET sort = (CASE sha %s ELSE sort END)
			WHERE repository = :repository
		';

		$sortCases = '';
		$sortSqlParams = [];

		// new commits first
		foreach ($allSHAs as $key => $sha) {
			$sortCases .= sprintf(' WHEN :sha_%d THEN :sort_%d', $key, $key);
			$sortSqlParams['sha_' . $key] = $sha;
			$sortSqlParams['sort_' . $key] = $key;
		}

		$sortSqlParams['repository'] = $repository->getName();
		$sql = sprintf($sortSQL, $sortCases);

		$this->connection->executeQuery($sql, $sortSqlParams, [
			'shas' => Connection::PARAM_STR_ARRAY,
		]);
	}

}
