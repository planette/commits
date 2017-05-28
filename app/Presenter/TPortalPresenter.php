<?php

declare(strict_types = 1);

namespace App\Presenter;

use App\Control\Navigation\NavigationControl;
use App\Control\Navigation\NavigationControlFactory;


trait TPortalPresenter
{

	/** @inject */
	public NavigationControlFactory $navigationControlFactory;


	protected function createComponentNavigation(): NavigationControl
	{
		return $this->navigationControlFactory->create();
	}

}
