<?php

use App\Commands\CalculateVacation;

require __DIR__ . '/../vendor/autoload.php';

$consoleCommand = new CalculateVacation();
$consoleCommand->execute($argv);
