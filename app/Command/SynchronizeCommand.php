<?php

declare(strict_types = 1);

namespace App\Command;

use App\Entity\Repository;
use Latte\Runtime\Filters;
use Symfony\Component\Lock\LockInterface;
use App\Synchronization\CommitSynchronizer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Synchronization\SynchronizationLog;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


final class SynchronizeCommand extends Command
{

	private LockInterface $lock;
	private CommitSynchronizer $commitSynchronizer;
	private SymfonyStyle $io;

	// phpcs:disable SlevomatCodingStandard.TypeHints.PropertyTypeHint
	protected static $defaultName = 'synchronize';
	// phpcs:enable


	public function __construct(LockInterface $lock, CommitSynchronizer $commitSynchronizer)
	{
		parent::__construct();

		$this->lock = $lock;
		$this->commitSynchronizer = $commitSynchronizer;
	}


	protected function configure(): void
	{
		$this->setDescription('Synchronizes commits in all repositories.')
			->addArgument('repository', InputArgument::OPTIONAL, 'Name of repository you want to synchronize. Leave empty to synchronize all repositories.');
	}


	protected function initialize(InputInterface $input, OutputInterface $output): void
	{
		$this->io = new SymfonyStyle($input, $output);
	}


	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$this->io->title('Commits Synchronizer');

		if (!$this->lock->acquire()) {
			$this->io->error('Synchronization already in process - aborting.');
			return 1;
		}

		/** @var string|null $repository */
		$repository = $input->getArgument('repository');

		$this->commitSynchronizer->synchronize(
			$repository,

			// on synchronization start
			function ($repositoryCount): void {
				$this->io->text(sprintf('Synchronizing commits in %d repositories...', $repositoryCount));
			},

			// on repository start
			function (int $index, Repository $repository): void {
				$this->io->section(sprintf("#%d %s", $index + 1, $repository->getName()));
			},

			// on commit start
			function (int $index, string $sha): void {
				$this->io->write(sprintf("\r#%d %s", $index + 1, substr($sha, 0, 7)));
			},

			// on commits finish
			function (): void {
				$this->io->write("\n Deleting unreachables...");
			},

			// on unreachables deleted
			function (int $count): void {
				$this->io->write(sprintf(" OK (%d)\n Updating commits order...", $count));
			},

			// on commits order updated
			function (): void {
				$this->io->write(' OK');
			},

			// on synchronization finish
			function (SynchronizationLog $syncLog): void {
				$this->io->success(sprintf('Finished in %d seconds', $syncLog->getElapsedSeconds()));

				$this->io->table([], [
					['Memory Peak', Filters::bytes((float) $syncLog->getMemoryPeak())],
					['API calls', $syncLog->getApiCalls()],
					['New Commits', $syncLog->getNewCommits()],
					['Deleted Commits', $syncLog->getDeletedCommits()],
				]);
			}

		);

		$this->lock->release();

		return 0;
	}

}
