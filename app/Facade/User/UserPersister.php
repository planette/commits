<?php

declare(strict_types = 1);

namespace App\Facade\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


final class UserPersister
{

	private EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}


	public function persistWithoutFlush(User $user): void
	{
		$this->em->persist($user);
	}

}
