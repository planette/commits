<?php

declare(strict_types = 1);

namespace App\QueryFunction\Repository;

use App\Entity\Repository;
use Doctrine\ORM\EntityManagerInterface;


final class RepositoriesSortedByProjectAndNameQuery
{

	private EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}


	/** @return Repository[] */
	public function get(?string $name): array
	{
		$qb = $this->em->createQueryBuilder()
			->select('r')
			->from(Repository::class, 'r')
			->join('r.project', 'p')
			->addOrderBy('p.sort', 'ASC')
			->addOrderBy('r.name', 'ASC');

		if ($name !== null) {
			$qb->andWhere('r.name = :name')
				->setParameter('name', $name);
		}

		return $qb->getQuery()->getResult();
	}

}
