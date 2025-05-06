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
                'days' => $this->calculateVacation($employee, $year),
            ];
        }

        return $results;
    }

    public static function calculateVacation(Employee $employee, int $year): int
    {
        $baseDays = $employee->getSpecialVacationDays() ?? 26;

        $start = $employee->getEmploymentStartForYear($year);
        $end = $employee->getEmploymentEndForYear($year);

        if (!$start || !$end) {
            return 0;
        }

        $age = $employee->getAgeOnYear($year);

        if ($age >= 30) {
            $employmentYears = $end->diff($employee->getContractStart())->y;
            $extraDays = intdiv($employmentYears, 5);
            $baseDays += $extraDays;
        }

        $month = (int)$start->format('n');
        $day = (int)$start->format('j');
        $startMonth = ($day <= 1) ? $month : (($day <= 15) ? $month : $month + 1);
        $monthsWorked = max(0, 12 - $startMonth + 1);

        if ($employee->getContractEnd()) {
            $endMonth = (int)$end->format('n');
            $monthsWorked = max(0, $endMonth - $startMonth + 1);
        }

        return (int)floor(($baseDays / 12) * $monthsWorked);
    }
}
