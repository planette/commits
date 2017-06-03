<?php

declare(strict_types = 1);

namespace App\Helper;

use Nette\StaticClass;
use App\Entity\CommitFile;


final class ChangeStatHelper
{

	use StaticClass;


	public static function getChangesStat(CommitFile $file): string
	{
		$stats = [];

		if ($file->getAdditions() === 0 && $file->getDeletions() === 0) {
			$stats[] = '0';

		} else {
			if ($file->getAdditions() > 0) {
				$stats[] = '+' . $file->getAdditions();
			}

			if ($file->getDeletions() > 0) {
				$stats[] = '-' . $file->getDeletions();
			}
		}

		return implode(', ', $stats);
	}

}
