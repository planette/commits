<?php

declare(strict_types = 1);

namespace App\QueryFunction\Project;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;


final class ProjectsSortedQuery
{

	private EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}


	/** @return Project[] */
	public function get(): array
	{
		return $this->em->createQueryBuilder()
			->select('p')
			->from(Project::class, 'p')
			->addOrderBy('p.sort', 'ASC')
			->getQuery()
			->enableResultCache(300)
			->getResult();
	}

}
