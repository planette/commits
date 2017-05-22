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
	public function get(): array
	{
		return $this->em->createQueryBuilder()
			->select('r')
			->from(Repository::class, 'r')
			->join('r.project', 'p')
			->addOrderBy('p.sort', 'ASC')
			->addOrderBy('r.name', 'ASC')
			->getQuery()
			->getResult();
	}

}
