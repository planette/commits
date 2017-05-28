<?php

declare(strict_types = 1);

namespace Tests;

use Tester\Assert;
use Nette\Application\Request;
use Tests\TestCase\WebTestCase;
use Nette\Application\Responses\TextResponse;


require_once __DIR__ . '/bootstrap.php';


final class ProjectPresenterTest extends WebTestCase
{

	/** @dataProvider project-slugs.ini */
	public function testActionCommits(string $projectSlug): void
	{
		$response = $this->request(new Request('Project', 'GET', [
			'action' => 'commits',
			'projectSlug' => $projectSlug,
		]));

		Assert::type(TextResponse::class, $response);
	}

}


(new ProjectPresenterTest)->run();
