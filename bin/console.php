<?php

use App\Commands\CalculateVacationCommand;
use Symfony\Component\Console\Application;

require __DIR__ . '/../vendor/autoload.php';

$application = new Application();
$application->add(new CalculateVacationCommand());
$application->run();
