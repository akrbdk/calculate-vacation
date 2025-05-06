<?php

namespace App\Models;

use App\Models\Contracts\YearDefinition;
use App\Models\Traits\Year;
use DateTime;

class Employee implements YearDefinition
{
    use Year;

    public function __construct(
        private readonly string    $name,
        private readonly DateTime  $birthDate,
        private readonly DateTime  $contractStart,
        private readonly ?DateTime $contractEnd,
        private readonly ?int      $specialVacationDays = null
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContractStart(): DateTime
    {
        return $this->contractStart;
    }

    public function getContractEnd(): ?DateTime
    {
        return $this->contractEnd;
    }

    public function getSpecialVacationDays(): ?int
    {
        return $this->specialVacationDays;
    }

    public function getEmploymentStartForYear(int $year): ?DateTime
    {
        if ((int)$this->contractStart->format('Y') > $year) {
            return null;
        }

        $onDate = $this->getStartYearDate($year);

        return max($this->contractStart, $onDate);
    }

    public function getEmploymentEndForYear(int $year): ?DateTime
    {
        if ($this->contractEnd && (int)$this->contractEnd->format('Y') < $year) {
            return null;
        }

        $onDate = $this->getEndYearDate($year);

        return $this->contractEnd && $this->contractEnd < $onDate ? $this->contractEnd : $onDate;
    }

    public function getAgeOnYear(int $year): int
    {
        $onDate = $this->getEndYearDate($year);

        return $this->birthDate->diff($onDate)->y;
    }
}
