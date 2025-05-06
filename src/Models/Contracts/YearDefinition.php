<?php

namespace App\Models\Contracts;

use DateTime;

interface YearDefinition
{
    public function getStartYearDate(int $year): DateTime;

    public function getEndYearDate(int $year): DateTime;
}
