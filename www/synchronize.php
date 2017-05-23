<?php

declare(strict_types = 1);

use App\Entity\Repository;
use Latte\Runtime\Filters;
use Symfony\Component\Lock\LockInterface;
use App\Synchronization\CommitSynchronizer;
use App\Entity\Synchronization\SynchronizationLog;

require_once __DIR__ . '/../vendor/autoload.php';


@set_time_limit(0);

(static function (Nette\DI\Container $container): void {

	/** @var LockInterface $lock */
	$lock = $container->getByType(LockInterface::class);

	if (!$lock->acquire()) {
		echo 'Synchronization already in process - aborting.';
		exit(1);
	}

	/** @var CommitSynchronizer $synchronizer */
	$synchronizer = $container->getByType(CommitSynchronizer::class);

	$synchronizer->synchronize(

		null,

		// on synchronization start
		static function ($repositoryCount): void {
			echo sprintf('Synchronizing commits in %d repositories...', $repositoryCount);
		},

		// on repository start
		static function (int $index, Repository $repository): void {},

		// on commit start
		static function (int $index, string $sha): void {},

		// on commits finish
		static function (): void {},

		// on unreachables deleted
		static function (int $count): void {},

		// on commits order updated
		static function (): void {},

		// on synchronization finish
		static function (SynchronizationLog $syncLog): void {
			echo sprintf('
Finished in %d seconds
- memory peak: %s
- API calls: %d
- new commits: %d
- deleted commits: %d
',
				$syncLog->getElapsedSeconds(),
				Filters::bytes((float) $syncLog->getMemoryPeak()),
				$syncLog->getApiCalls(),
				$syncLog->getNewCommits(),
				$syncLog->getDeletedCommits()
			);
		}

	);

	$lock->release();

})(App\Bootstrap::boot()->createContainer());
