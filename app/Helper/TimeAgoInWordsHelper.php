<?php

declare(strict_types = 1);

namespace App\Helper;


final class TimeAgoInWordsHelper
{

	/** @author David Grudl */
	public static function convert(\DateTimeInterface $datetime): ?string
	{
		$time = (int) $datetime->format('U');
		$delta = time() - $time;

		if ($delta < 0) {
			return null;
		}

		$delta = (int) round($delta / 60);
		if ($delta === 0) return 'just now';
		if ($delta === 1) return 'a minute ago';
		if ($delta < 45) return "$delta minutes ago";
		if ($delta < 90) return 'an hour ago';
		if ($delta < 1440) return round($delta / 60) . ' hours ago';
		if ($delta < 2880) return 'yesterday';
		if ($delta < 43200) return round($delta / 1440) . ' days ago';
		if ($delta < 86400) return 'a month ago';
		if ($delta < 525960) return round($delta / 43200) . ' months ago';
		if ($delta < 1051920) return 'a year ago';
		return round($delta / 525960) . ' years ago';
	}

}
