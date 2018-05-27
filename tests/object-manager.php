<?php

declare(strict_types = 1);

use App\Bootstrap;
use Doctrine\Persistence\ObjectManager;

require __DIR__ . '/../vendor/autoload.php';

return Bootstrap::boot()->createContainer()->getByType(ObjectManager::class);
