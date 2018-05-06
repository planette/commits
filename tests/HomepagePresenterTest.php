<?php

declare(strict_types = 1);

namespace Tests;

use Tester\Assert;
use Nette\Application\Request;
use Tests\TestCase\WebTestCase;
use Nette\Application\Responses\TextResponse;


require_once __DIR__ . '/bootstrap.php';


final class HomepagePresenterTest extends WebTestCase
{

	public function testActionDefault(): void
	{
		$response = $this->request(new Request('Homepage', 'GET', [
			'action' => 'default',
		]));

		Assert::type(TextResponse::class, $response);
	}

}


(new HomepagePresenterTest)->run();
