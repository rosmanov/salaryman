<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191002120438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates `page` table.';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            'CREATE TABLE page (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL COMMENT "Human-readable name of the page",
                uri VARCHAR(255) NOT NULL COMMENT "Page URI relative to the base URL, with a leading slash",
                `position` INT NOT NULL COMMENT "Page order in the sorted list of pages",
                PRIMARY KEY(id),
                INDEX `position`(`position`),
                INDEX `uri`(`uri`)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE page');
    }
}
