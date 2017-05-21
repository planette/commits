<?php

declare(strict_types = 1);

namespace App\Presenter;

use Tracy\ILogger;
use Nette\Application\Request;
use Nette\Application\Helpers;
use Nette\Application\Response;
use Nette\Application\IPresenter;
use Nette\Application\BadRequestException;
use Nette\Application\Responses\ForwardResponse;
use Nette\Application\Responses\CallbackResponse;


final class ErrorPresenter implements IPresenter
{

	private ILogger $logger;


	public function __construct(ILogger $logger)
	{
		$this->logger = $logger;
	}


	public function run(Request $request): Response
	{
		$exception = $request->getParameter('exception');

		if ($exception instanceof BadRequestException) {
			[$module, , $sep] = Helpers::splitName($request->getPresenterName());
			return new ForwardResponse($request->setPresenterName($module . $sep . 'Error4xx'));
		}

		$this->logger->log($exception, ILogger::EXCEPTION);
		return new CallbackResponse(static function (): void {
			require __DIR__ . '/templates/Error/500.phtml';
		});
	}

}
