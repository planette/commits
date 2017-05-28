<?php

declare(strict_types = 1);

namespace App\Helper;


final class FileMtimeHelper
{

	private string $wwwDir;


	public function __construct(string $wwwDir)
	{
		$this->wwwDir = rtrim($wwwDir, '/\\');
	}


	public function getMtime(string $relPath): int
	{
		return (int) @filemtime($this->wwwDir . '/' . ltrim($relPath, '/\\'));
	}

}
