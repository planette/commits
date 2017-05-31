<?php

declare(strict_types = 1);

namespace App\QueryFunction\Commit;

use App\Entity\Commit;
use App\Entity\Project;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\EntityManagerInterface;


final class CommitsFilteredByProjectQueryFactory
{

	private EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}


	/** @param  array<string, string> $filters */
	public function create(Project $project, array $filters): QueryBuilder
	{
		$qb = $this->em->createQueryBuilder()
			->select('c')
			->from(Commit::class, 'c');

		$repoJoinWith = 'r.project = :project';

		if (isset($filters['repository'])) {
			$repoJoinWith .= ' AND r.name = :repository_name';
			$qb->setParameter('repository_name', $filters['repository']);
		}

		$qb->join('c.repository', 'r', Join::WITH, $repoJoinWith)
			->leftJoin('c.author', 'a')
			->leftJoin('c.committer', 'cmt')
			->setParameter('project', $project);

		if (isset($filters['author'])) {
			$qb->andWhere('a.login LIKE :author OR c.authorName LIKE :author')
				->setParameter('author', '%' . $filters['author'] . '%');
		}

		if (isset($filters['message'])) {
			$qb->andWhere('c.message LIKE :message')
				->setParameter('message', '%' . $filters['message'] . '%');
		}

		if (isset($filters['sha'])) {
			$qb->andWhere('c.sha LIKE :sha')
				->setParameter('sha', '%' . $filters['sha'] . '%');
		}

		return $qb;
	}

}
