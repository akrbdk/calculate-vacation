<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\Employee;

class EmployeeTest extends TestCase
{
    public function testMinimumVacationDays(): void
    {
        $employee = new Employee(
            'Employee',
            new \DateTime('1990-01-01'),
            new \DateTime('2010-01-01'),
            null
        );
        $days = $employee->calculateVacationDaysForYear(2024);
        $this->assertEquals(26 + 2, $days);
    }

    public function testSpecialContractVacationDays(): void
    {
        $employee = new Employee(
            'Employee',
            new \DateTime('1990-01-01'),
            new \DateTime('2020-01-01'),
            null,
            32
        );
        $days = $employee->calculateVacationDaysForYear(2024);
        $this->assertEquals(32, $days);
    }

    public function testPartialEmploymentFrom15th(): void
    {
        $employee = new Employee(
            'Employee',
            new \DateTime('1990-01-01'),
            new \DateTime('2024-03-15'),
            null
        );
        $days = $employee->calculateVacationDaysForYear(2024);
        $daysExpected = intval(26 / 12 * 10);
        $this->assertEquals($daysExpected, $days);
    }

    public function testContractEndedBeforeYear(): void
    {
        $employee = new Employee(
            'Employee',
            new \DateTime('1980-01-01'),
            new \DateTime('2010-01-01'),
            new \DateTime('2023-12-31')
        );
        $days = $employee->calculateVacationDaysForYear(2024);
        $this->assertEquals(0, $days);
    }

    public function testAdditionalDaysByAgeAndYears(): void
    {
        $employee = new Employee(
            'Employee',
            new \DateTime('1980-01-01'),
            new \DateTime('2010-01-01'),
            null
        );
        $days = $employee->calculateVacationDaysForYear(2024);
        $this->assertEquals(28, $days);
    }
}
