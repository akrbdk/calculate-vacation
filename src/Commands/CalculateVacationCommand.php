<?php

namespace App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use App\Repositories\EmployeeRepository;
use App\Services\EmployeeService;

#[AsCommand(
    name: 'calculate:vacation',
    description: 'Calculates vacation.',
    hidden: false
)]

final class CalculateVacationCommand extends Command
{
    protected function configure(): void
    {
        $this->setDescription('Calculating vacation days for employees for a given year.')
            ->addArgument('year', InputArgument::REQUIRED, 'The year to calculate for');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $year = (int) $input->getArgument('year');

        $repository = new EmployeeRepository(__DIR__ . '/../../data/employees-list.csv');
        $service = new EmployeeService($repository);
        $employees = $service->getEmployees($year);

        if (empty($employees)) {
            $output->writeln('Employees not found');
            return Command::FAILURE;
        }

        foreach ($employees as $employee) {
            $output->writeln($employee['name'] . ": " . $employee['days'] . " vacation days in $year");
        }

        return Command::SUCCESS;
    }
}
