<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Employee;
use App\Services\EmployeeService;
use DateTime;
use PHPUnit\Framework\TestCase;

final class EmployeeTest extends TestCase
{
    /**
     * @dataProvider vacationDataProvider
     */
    public function testVacationCalculation(
        string $name,
        string $birthDate,
        string $contractStart,
        ?string $contractEnd,
        ?int $specialDays,
        int $expected
    ): void {
        $employee = new Employee(
            $name,
            new DateTime($birthDate),
            new DateTime($contractStart),
            $contractEnd ? new DateTime($contractEnd) : null,
            $specialDays
        );

        $actual = EmployeeService::calculateVacation($employee, 2024);
        $this->assertEquals($expected, $actual);
    }

    public static function vacationDataProvider(): array
    {
        return [
            // name, birthDate, contractStart, contractEnd, specialDays, expected
            'minimum with bonus' => [
                'Test Employee', '1990-01-01', '2010-01-01', null, null, 28
            ],
            'special contract full year' => [
                'Special Contract', '1990-01-01', '2020-01-01', null, 32, 32
            ],
            'partial from 15th March' => [
                'Partial', '1990-01-01', '2024-03-15', null, null, (int) (26 / 12 * 10)
            ],
            'ended before year' => [
                'Left Employee', '1980-01-01', '2010-01-01', '2023-12-31', null, 0
            ],
            'older with 14 years' => [
                'Older', '1980-01-01', '2010-01-01', null, null, 28
            ],
        ];
    }
}
