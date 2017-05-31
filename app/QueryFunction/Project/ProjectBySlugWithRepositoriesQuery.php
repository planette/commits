<?php

declare(strict_types = 1);

namespace App\QueryFunction\Project;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;


final class ProjectBySlugWithRepositoriesQuery
{

	private EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}


	/** @throws ProjectNotFoundException */
	public function get(string $slug): Project
	{
		$project = $this->em->createQueryBuilder()
			->select('p', 'rs')
			->from(Project::class, 'p')
			->leftJoin('p.repositories', 'rs')
			->andWhere('p.slug = :slug')
			->setParameter('slug', $slug)
			->getQuery()
			->getOneOrNullResult();

		if ($project === null) {
			throw ProjectNotFoundException::bySlug($slug);
		}

		return $project;
	}

}
