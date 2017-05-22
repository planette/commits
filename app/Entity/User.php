<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/** @ORM\Entity(repositoryClass = "App\Repository\UserRepository") */
class User
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type = "string")
	 */
	private string $id;

	/** @ORM\Column(type = "integer", unique = true) */
	private int $githubID;

	/** @ORM\Column(type = "string") */
	private string $login;

	/** @ORM\Column(type = "string", nullable = true) */
	private ?string $avatarURL;


	public function __construct(int $githubID, string $login, ?string $avatarURL)
	{
		$this->login = $login;
		$this->id = ID::generate();
		$this->githubID = $githubID;
		$this->avatarURL = $avatarURL;
	}


	public function merge(string $login, ?string $avatarURL): void
	{
		$this->login = $login;
		$this->avatarURL = $avatarURL;
	}

}
