<?php

declare(strict_types = 1);

namespace App\Facade\SynchronizationLog;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Synchronization\SynchronizationLog;


final class SynchronizationLogPersister
{

	private EntityManagerInterface $em;


	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}


	public function persist(SynchronizationLog $log): void
	{
		$this->em->persist($log);
		$this->em->flush();
	}

}
