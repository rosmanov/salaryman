<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191002150205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates `employee` table';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            'CREATE TABLE employee (
                id INT AUTO_INCREMENT NOT NULL,
                first_name VARCHAR(255) NOT NULL DEFAULT "",
                middle_name VARCHAR(255) NOT NULL DEFAULT "",
                last_name VARCHAR(255) NOT NULL DEFAULT "",
                age INT NOT NULL DEFAULT 0,
                using_company_car TINYINT(1) NOT NULL DEFAULT 0,
                base_salary DOUBLE PRECISION NOT NULL DEFAULT 0,
                actual_salary DOUBLE PRECISION NOT NULL DEFAULT 0 COMMENT "`base_salary` with the salary factors applied",
                kids INT NOT NULL DEFAULT 0 COMMENT "The number of kids",
                `created` timestamp NOT NULL DEFAULT current_timestamp(),
                `modified` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY(id),
                INDEX first_name(first_name(10)),
                INDEX last_name(last_name(10)),
                INDEX `age`(`age`),
                INDEX `kids`(`kids`)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        // Insert sample rows
        $rows = [
            ['first_name' => 'John',    'middle_name' => 'Jr.', 'last_name' => 'Doe',     'age' => 24, 'using_company_car' => 1, 'base_salary' => 2000, 'kids' => 0, ],
            ['first_name' => 'Ruslan',  'middle_name' => '',    'last_name' => 'Osmanov', 'age' => 32, 'using_company_car' => 0, 'base_salary' => 3800, 'kids' => 1, ],
            ['first_name' => 'Maria',   'middle_name' => '',    'last_name' => 'Simpson', 'age' => 30, 'using_company_car' => 1, 'base_salary' => 1900, 'kids' => 1, ],
            ['first_name' => 'Garry',   'middle_name' => '',    'last_name' => 'West',    'age' => 50, 'using_company_car' => 0, 'base_salary' => 800,  'kids' => 2, ],
            ['first_name' => 'James',   'middle_name' => '',    'last_name' => 'Smith',   'age' => 25, 'using_company_car' => 0, 'base_salary' => 800,  'kids' => 2, ],
            ['first_name' => 'Mike',    'middle_name' => '',    'last_name' => 'West',    'age' => 39, 'using_company_car' => 0, 'base_salary' => 1800, 'kids' => 2, ],
            ['first_name' => 'Ace',     'middle_name' => '',    'last_name' => 'Xargs',   'age' => 47, 'using_company_car' => 0, 'base_salary' => 1830, 'kids' => 1, ],
            ['first_name' => 'Blake',   'middle_name' => '',    'last_name' => 'Brown',   'age' => 12, 'using_company_car' => 0, 'base_salary' => 3200, 'kids' => 0, ],
            ['first_name' => 'Marry',   'middle_name' => '',    'last_name' => 'Yellow',  'age' => 19, 'using_company_car' => 0, 'base_salary' => 2800, 'kids' => 5, ],
            ['first_name' => 'Kate',    'middle_name' => '',    'last_name' => 'White',   'age' => 29, 'using_company_car' => 0, 'base_salary' => 900,  'kids' => 0, ],
            ['first_name' => 'Emily',   'middle_name' => '',    'last_name' => 'Green',   'age' => 25, 'using_company_car' => 0, 'base_salary' => 500,  'kids' => 0, ],
            ['first_name' => 'Susanna', 'middle_name' => '',    'last_name' => 'Blue',    'age' => 33, 'using_company_car' => 0, 'base_salary' => 300,  'kids' => 6, ],
            ['first_name' => 'Brandon', 'middle_name' => '',    'last_name' => 'Pink',    'age' => 28, 'using_company_car' => 0, 'base_salary' => 200,  'kids' => 3, ],
        ];
        foreach ($rows as $row) {
            $this->addSql(
                'INSERT INTO employee SET
                    first_name = :first_name,
                    middle_name = :middle_name,
                    last_name = :last_name,
                    age = :age,
                    using_company_car = :using_company_car,
                    base_salary = :base_salary,
                    kids = :kids,
                    created = NULL',
                $row
            );
        }
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE employee');
    }
}
