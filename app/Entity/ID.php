<?php

declare(strict_types = 1);

namespace App\Entity;

use Nette\Utils\Random;


final class ID
{

	public static function generate(): string
	{
		return Random::generate(8, 'a-z0-9');
	}

}
