<?php

declare(strict_types = 1);

namespace App\QueryFunction\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


final class UsersIndexedByGithubIdQuery
{

	private EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}


	/** @return User[] */
	public function get(): array
	{
		return $this->em->createQueryBuilder()
			->select('u')
			->from(User::class, 'u')
			->indexBy('u', 'u.githubID')
			->getQuery()
			->getResult();
	}

}
