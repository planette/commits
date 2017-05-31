<?php

declare(strict_types = 1);

namespace App\QueryFunction\Commit;

use App\Entity\Commit;
use App\Entity\Project;
use TwiGrid\Components\Column;


final class CommitsFilteredByProjectQuery
{

	private CommitsFilteredByProjectQueryFactory $filterQueryFactory;


	public function __construct(CommitsFilteredByProjectQueryFactory $filterQueryFactory)
	{
		$this->filterQueryFactory = $filterQueryFactory;
	}


	/**
	 * @param  array<string, string> $filters
	 * @param  array<string, bool> $orderBy
	 * @return Commit[]
	 */
	public function get(Project $project, array $filters, array $orderBy, int $limit, int $offset): array
	{
		$qb = $this->filterQueryFactory->create($project, $filters)
			->select('c', 'r', 'a', 'cmt')
			->setMaxResults($limit)
			->setFirstResult($offset);

		if (isset($orderBy['committed_at'])) {
			$orderASC = $orderBy['committed_at'] === Column::ASC;

			$qb->addOrderBy('c.committedAt', $orderASC ? 'ASC' : 'DESC')
				->addOrderBy('c.sort', $orderASC ? 'DESC' : 'ASC');
		}

		return $qb->getQuery()->getResult();
	}

}
