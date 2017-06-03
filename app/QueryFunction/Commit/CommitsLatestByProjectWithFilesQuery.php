<?php

declare(strict_types = 1);

namespace App\QueryFunction\Commit;

use App\Entity\Commit;
use App\Entity\Project;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\EntityManagerInterface;


final class CommitsLatestByProjectWithFilesQuery
{

	private EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}


	/** @return Commit[] */
	public function get(Project $project, int $max): array
	{
		// NOTE: intentionally manual shas fetching (Doctrine Paginator cannot handle composite keys)

		$shas = $this->em->createQueryBuilder()
			->select('c.sha')
			->from(Commit::class, 'c')
			->join('c.repository', 'r', Join::WITH, 'r.project = :project')
			->setParameter('project', $project)
			->addOrderBy('c.authoredAt', 'DESC')
			->setMaxResults($max)
			->getQuery()
			->getScalarResult();

		// get commits with relations
		return $this->em->createQueryBuilder()
			->select('c', 'r', 'a', 'f')
			->from(Commit::class, 'c')
			->join('c.repository', 'r', Join::WITH, 'r.project = :project')
			->leftJoin('c.author', 'a')
			->leftJoin('c.files', 'f')
			->setParameter('project', $project)
			->andWhere('c.sha IN (:shas)')
			->setParameter('shas', array_column($shas, 'sha'))
			->addOrderBy('c.authoredAt', 'DESC')
			->getQuery()
			->getResult();
	}

}
