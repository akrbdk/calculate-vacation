# calculate-vacation

This is a simple console application for calculating the number of vacation days for each employee.

## Installation using docker

1. Clone the project using git
2. Copy `.env.example` into `.env` (Don't need to change anything for local development)
3. Navigate to the project root directory and run `docker compose up -d`
4. Install dependencies - `docker exec calculate-vacation-app-1 composer install`
5. Run your script - `docker exec calculate-vacation-app-1 php bin/console.php`
6. Run tests - `docker exec calculate-vacation-app-1 vendor/bin/phpunit tests`
