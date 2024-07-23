<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240121122200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create test_user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS test_user 
        (id UUID PRIMARY KEY, 
         email VARCHAR(255) NOT NULL, 
         initials VARCHAR(255) NOT NULL, 
         password VARCHAR(255) NOT NULL, 
         confirmed BOOLEAN NOT NULL, 
         UNIQUE (email))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE test_user');
    }
}
