<?php

namespace App\Commands\Contracts;

interface Command
{
    public function execute(array $argv): void;
}
