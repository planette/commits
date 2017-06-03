<?php

declare(strict_types = 1);

namespace App\Helper;

use Nette\StaticClass;


final class Pluralizer
{

	use StaticClass;


	public static function getForm(int $n, string $singular, string $plural): string
	{
		return $n === 1 ? $singular : $plural;
	}

}
