<?php

declare(strict_types = 1);

namespace App\Entity;


class User
{

	private string $id;
	private int $githubID;
	private string $login;
	private ?string $avatarURL;


	public function __construct(int $githubID, string $login, ?string $avatarURL)
	{
		$this->login = $login;
		$this->id = ID::generate();
		$this->githubID = $githubID;
		$this->avatarURL = $avatarURL;
	}

}
