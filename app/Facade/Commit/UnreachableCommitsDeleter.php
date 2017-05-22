<?php

declare(strict_types = 1);

namespace App\Facade\Commit;

use App\Entity\Repository;
use Doctrine\DBAL\Connection;


final class UnreachableCommitsDeleter
{

	private Connection $connection;


	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}


	/** @param  string[] $allSHAs */
	public function delete(Repository $repository, array $allSHAs): void
	{
		if (count($allSHAs) === 0) {
			return ;
		}

		$this->connection->executeStatement('
			DELETE FROM `commit`
			WHERE repository = :repository
				AND sha NOT IN (:shas)

		', [
			'repository' => $repository->getID(),
			'shas' => $allSHAs,

		], [
			'shas' => Connection::PARAM_STR_ARRAY,
		]);
	}

}
