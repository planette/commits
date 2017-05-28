<?php

declare(strict_types = 1);

namespace App\Control\Navigation;


interface NavigationControlFactory
{

	public function create(): NavigationControl;

}
