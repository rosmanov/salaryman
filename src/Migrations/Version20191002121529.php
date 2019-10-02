<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191002121529 extends AbstractMigration
{
    /**
     * @var array[]
     */
    private $pages;

    public function getDescription() : string
    {
        return 'Fills in the `page` table';
    }

    public function preUp(Schema $schema) : void
    {
        $this->init();
    }

    public function preDown(Schema $schema) : void
    {
        $this->init();

    }

    private function init() : void
    {
        $this->pages[] = ['uri' => '/', 'name' => 'Employees', 'position' => 0];
        $this->pages[] = ['uri' => '/salary-factors', 'name' => 'Salary Factors', 'position' => 1];
    }

    public function up(Schema $schema) : void
    {
        foreach ($this->pages as $page) {
            $this->addSql('INSERT INTO page SET uri = :uri, name = :name, position = :position', $page);
        }
    }

    public function down(Schema $schema) : void
    {
        foreach ($this->pages as $page) {
            $this->addSql('DELETE FROM page WHERE uri = :uri', $page);
        }
    }
}
