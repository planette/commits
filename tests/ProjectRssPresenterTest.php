<?php

declare(strict_types = 1);

namespace Tests;

use Tester\Assert;
use Nette\Application\Request;
use Tests\TestCase\WebTestCase;
use Nette\Application\Responses\TextResponse;


require_once __DIR__ . '/bootstrap.php';


final class ProjectRssPresenterTest extends WebTestCase
{

	public function getPresenterName(): string
	{
		return 'ProjectRss';
	}


	/** @dataProvider project-slugs.ini */
	public function testActionCommits(string $projectSlug): void
	{
		$response = $this->request(new Request('ProjectRss', 'GET', [
			'action' => 'feed',
			'projectSlug' => $projectSlug,
		]));

		Assert::type(TextResponse::class, $response);
	}

}


(new ProjectRssPresenterTest)->run();
