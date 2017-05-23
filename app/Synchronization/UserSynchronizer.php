<?php

declare(strict_types = 1);

namespace App\Synchronization;

use App\Entity\User;
use App\Facade\User\UserPersister;
use App\Entity\Synchronization\RepositoryLog;
use App\QueryFunction\User\UsersIndexedByGithubIdQuery;


final class UserSynchronizer
{

	private UsersIndexedByGithubIdQuery $usersQuery;
	private UserPersister $userPersister;

	/** @var User[]|null */
	private ?array $users = null;


	public function __construct(UsersIndexedByGithubIdQuery $usersQuery, UserPersister $userPersister)
	{
		$this->usersQuery = $usersQuery;
		$this->userPersister = $userPersister;
	}


	public function synchronize(RepositoryLog $repositoryLog, int $githubID, string $login, ?string $avatarURL): User
	{
		if ($this->users === null) {
			$this->users = $this->usersQuery->get();
		}

		if (isset($this->users[$githubID])) {
			$local = $this->users[$githubID];
			$local->merge($login, $avatarURL);

		} else {
			$local = new User($githubID, $login, $avatarURL);
			$repositoryLog->newUser();
		}

		$this->userPersister->persistWithoutFlush($local);
		$this->users[$githubID] = $local;

		return $local;
	}

}
