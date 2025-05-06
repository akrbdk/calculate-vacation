<?php

namespace App\Models\Traits;

use DateTime;

trait Year
{
    public function getStartYearDate(int $year): DateTime
    {
        return new DateTime("$year-01-01");
    }

    public function getEndYearDate(int $year): DateTime
    {
        return new DateTime("$year-12-31");
    }
}
