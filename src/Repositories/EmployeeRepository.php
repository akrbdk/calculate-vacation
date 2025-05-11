<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Employee;
use DateTime;
use Exception;

final class EmployeeRepository
{
    public function __construct(private readonly string $path)
    {

    }

    /**
     * @throws Exception
     */
    public function findAll(): array
    {
        $employees = [];

        if (!file_exists($this->path)) {
            return $employees;
        }

        $rows = array_map('str_getcsv', file($this->path));
        array_shift($rows);

        foreach ($rows as $row) {
            $row += ['', null, null, ''];

            [$name, $birthDate, $contractStart, $specialDays] = $row;

            $employees[] = new Employee(
                $name,
                new DateTime($birthDate),
                new DateTime($contractStart),
                new DateTime(),
                $specialDays !== '' ? (int)$specialDays : null
            );
        }

        return $employees;
    }
}
