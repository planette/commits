<?php

declare(strict_types = 1);

namespace App\QueryFunction\Commit;

use App\Entity\Project;
use Doctrine\ORM\Tools\Pagination\Paginator;


final class CommitsFilteredByProjectCountQuery
{

	private CommitsFilteredByProjectQueryFactory $filterQueryFactory;


	public function __construct(CommitsFilteredByProjectQueryFactory $commitsFilteredQuery)
	{
		$this->filterQueryFactory = $commitsFilteredQuery;
	}


	/** @param  array<string, string> $filters */
	public function get(Project $project, array $filters): int
	{
		return count(new Paginator($this->filterQueryFactory->create($project, $filters)));
	}

}
