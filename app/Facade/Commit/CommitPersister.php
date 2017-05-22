<?php

declare(strict_types = 1);

namespace App\Facade\Commit;

use App\Entity\Commit;
use Doctrine\ORM\EntityManagerInterface;


final class CommitPersister
{

	private EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}


	public function persistWithoutFlush(Commit $commit): void
	{
		$this->em->persist($commit);
	}


	public function flush(): void
	{
		$this->em->flush();
	}

}
