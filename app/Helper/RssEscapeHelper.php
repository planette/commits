<?php

declare(strict_types = 1);

namespace App\Helper;

use Nette\StaticClass;


final class RssEscapeHelper
{

	use StaticClass;


	public static function escape(string $s): string
	{
		return str_replace('<', '&#x3C;', str_replace('&', '&#x26;', $s));
	}

}
