<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;

class EmployeeService
{
    public function __construct(private readonly EmployeeRepository $employeeRepository)
    {

    }

    public function getEmployees(int $year): array
    {
        $results = [];

        /** @var Employee $employee */
        foreach ($this->employeeRepository->findAll() as $employee) {
            $results[] = [
                'name' => $employee->getName(),
                'days' => $employee->calculateVacationDaysForYear($year),
            ];
        }

        return $results;
    }
}
