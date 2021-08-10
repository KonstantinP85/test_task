<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210810174545 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE access_matrix (id UUID NOT NULL, role_id UUID NOT NULL, action_id UUID NOT NULL, object_class_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AB8D4FDD60322AC ON access_matrix (role_id)');
        $this->addSql('CREATE INDEX IDX_AB8D4FD9D32F035 ON access_matrix (action_id)');
        $this->addSql('CREATE INDEX IDX_AB8D4FD3CD6E678 ON access_matrix (object_class_id)');
        $this->addSql('CREATE TABLE actions (id UUID NOT NULL, name VARCHAR(255) NOT NULL, signature VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE object_class (id UUID NOT NULL, name VARCHAR(255) NOT NULL, source_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE roles (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE access_matrix ADD CONSTRAINT FK_AB8D4FDD60322AC FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE access_matrix ADD CONSTRAINT FK_AB8D4FD9D32F035 FOREIGN KEY (action_id) REFERENCES actions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE access_matrix ADD CONSTRAINT FK_AB8D4FD3CD6E678 FOREIGN KEY (object_class_id) REFERENCES actions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE access_matrix DROP CONSTRAINT FK_AB8D4FD9D32F035');
        $this->addSql('ALTER TABLE access_matrix DROP CONSTRAINT FK_AB8D4FD3CD6E678');
        $this->addSql('ALTER TABLE access_matrix DROP CONSTRAINT FK_AB8D4FDD60322AC');
        $this->addSql('DROP TABLE access_matrix');
        $this->addSql('DROP TABLE actions');
        $this->addSql('DROP TABLE object_class');
        $this->addSql('DROP TABLE roles');
    }
}
