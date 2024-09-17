<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240912111942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_history ADD employe_id INT DEFAULT NULL, ADD commande_id INT DEFAULT NULL, ADD plat VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation_history ADD CONSTRAINT FK_402FCBCE1B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE reservation_history ADD CONSTRAINT FK_402FCBCE82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_402FCBCE1B65292 ON reservation_history (employe_id)');
        $this->addSql('CREATE INDEX IDX_402FCBCE82EA2E54 ON reservation_history (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_history DROP FOREIGN KEY FK_402FCBCE1B65292');
        $this->addSql('ALTER TABLE reservation_history DROP FOREIGN KEY FK_402FCBCE82EA2E54');
        $this->addSql('DROP INDEX IDX_402FCBCE1B65292 ON reservation_history');
        $this->addSql('DROP INDEX IDX_402FCBCE82EA2E54 ON reservation_history');
        $this->addSql('ALTER TABLE reservation_history DROP employe_id, DROP commande_id, DROP plat');
    }
}
