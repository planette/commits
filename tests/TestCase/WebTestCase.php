<?php

declare(strict_types = 1);

namespace Tests\TestCase;

use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\UI\Presenter;
use Nette\Application\IPresenterFactory;


abstract class WebTestCase extends ContainerTestCase
{

	final public function request(Request $request): Response
	{
		/** @var IPresenterFactory $presenterFactory */
		$presenterFactory = $this->container->getByType(IPresenterFactory::class);

		/** @var Presenter $presenter */
		$presenter = $presenterFactory->createPresenter($request->getPresenterName());

		$presenter->autoCanonicalize = false;

		return $presenter->run($request);
	}

}
