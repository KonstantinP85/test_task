<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210812004335 extends AbstractMigration
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
        $this->addSql('ALTER TABLE access_matrix DROP CONSTRAINT FK_AB8D4FD3CD6E678');
        $this->addSql('ALTER TABLE access_matrix ADD CONSTRAINT FK_AB8D4FD3CD6E678 FOREIGN KEY (object_class_id) REFERENCES object_class (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE access_matrix DROP CONSTRAINT fk_ab8d4fd3cd6e678');
        $this->addSql('ALTER TABLE access_matrix ADD CONSTRAINT fk_ab8d4fd3cd6e678 FOREIGN KEY (object_class_id) REFERENCES actions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
