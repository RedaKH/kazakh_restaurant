<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827175024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B969CCBE9A');
        $this->addSql('DROP INDEX IDX_F804D3B969CCBE9A ON employe');
        $this->addSql('ALTER TABLE employe DROP author_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe ADD author_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B969CCBE9A FOREIGN KEY (author_id_id) REFERENCES blog (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F804D3B969CCBE9A ON employe (author_id_id)');
    }
}
