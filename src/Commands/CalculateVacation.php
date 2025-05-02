<?php

namespace App\Commands;

use App\Commands\Contracts\Command;
use App\Repositories\EmployeeRepository;
use App\Services\EmployeeService;

class CalculateVacation implements Command
{

    public function execute(array $argv): void
    {
        $year = $argv[1] ?? null;
        if (!$year || !preg_match('/^\d{4}$/', $year)) {
            echo "Please use command: php bin/console.php <year>\n";
            exit(1);
        }

        $repository = new EmployeeRepository(__DIR__ . '/../../data/employees-list.csv');
        $service = new EmployeeService($repository);
        $employees = $service->getEmployees($year);

        if (empty($employees)) {
            echo 'Employees not found' . PHP_EOL;
            exit(1);
        }

        foreach ($employees as $employee) {
            echo $employee['name'] . ": " . $employee['days'] . " vacation days in $year" . PHP_EOL;
            echo str_repeat('-', 30) . PHP_EOL;
        }
    }
}
