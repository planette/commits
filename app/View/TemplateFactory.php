<?php

declare(strict_types = 1);

namespace App\View;

use Nette\Http\IRequest;
use Nette\Security\User;
use Nette\Caching\Storage;
use App\Helper\FileMtimeHelper;
use Nette\Application\UI\Control;
use Nette\Application\UI\Template;
use Nette\Bridges\ApplicationLatte\LatteFactory;


final class TemplateFactory extends \Nette\Bridges\ApplicationLatte\TemplateFactory
{

	private FileMtimeHelper $fileMtimeHelper;


	public function __construct(
		LatteFactory $latteFactory,
		?IRequest $httpRequest,
		?User $user,
		?Storage $cacheStorage,
		?string $templateClass,
		FileMtimeHelper $fileMtimeHelper

	) {
		parent::__construct($latteFactory, $httpRequest, $user, $cacheStorage, $templateClass);

		$this->fileMtimeHelper = $fileMtimeHelper;
	}


	public function createTemplate(?Control $control = null, ?string $class = null): Template
	{
		/** @var \Nette\Bridges\ApplicationLatte\Template $template */
		$template = parent::createTemplate($control, $class);

		$template->getLatte()
			->addFilter('mtime', function (string $relPath): string {
				return sprintf('%s?%d', $relPath, $this->fileMtimeHelper->getMtime($relPath));
			})
		;

		return $template;
	}

}
