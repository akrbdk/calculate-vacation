<?php

namespace App\Models;

class Employee
{
    public function __construct(
        private readonly string     $name,
        private readonly \DateTime  $birthDate,
        private readonly \DateTime  $contractStart,
        private readonly ?\DateTime $contractEnd,
        private readonly ?int $specialVacationDays = null
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getAgeOnYear(int $year): int
    {
        $onDate = $this->getEndYearDate($year);

        return $this->birthDate->diff($onDate)->y;
    }

    public function getEmploymentStartForYear(int $year): ?\DateTime
    {
        if ((int) $this->contractStart->format('Y') > $year) {
            return null;
        }

        $onDate = $this->getStartYearDate($year);

        return max($this->contractStart, $onDate);
    }

    public function getEmploymentEndForYear(int $year): ?\DateTime
    {
        if ($this->contractEnd && (int) $this->contractEnd->format('Y') < $year) {
            return null;
        }

        $onDate = $this->getEndYearDate($year);

        return $this->contractEnd && $this->contractEnd < $onDate ? $this->contractEnd : $onDate;
    }

    public function calculateVacationDaysForYear(int $year): int
    {
        $baseDays = $this->specialVacationDays ?? 26;

        $start = $this->getEmploymentStartForYear($year);
        $end = $this->getEmploymentEndForYear($year);

        if (!$start || !$end) {
            return 0;
        }

        $age = $this->getAgeOnYear($year);

        if ($age >= 30) {
            $employmentYears = $end->diff($this->contractStart)->y;
            $extraDays = intdiv($employmentYears, 5);
            $baseDays += $extraDays;
        }

        $month = (int) $start->format('n');
        $day = (int) $start->format('j');
        $startMonth = ($day <= 1) ? $month : (($day <= 15) ? $month : $month + 1);
        $monthsWorked = max(0, 12 - $startMonth + 1);

        if ($this->contractEnd) {
            $endMonth = (int) $end->format('n');
            $monthsWorked = max(0, $endMonth - $startMonth + 1);
        }

        return (int) floor(($baseDays / 12) * $monthsWorked);
    }

    public function getStartYearDate(int $year): \DateTime
    {
        return new \DateTime("$year-01-01");
    }

    public function getEndYearDate(int $year): \DateTime
    {
        return new \DateTime("$year-12-31");
    }
}
