<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240823111429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image VARCHAR(500) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, plat VARCHAR(255) NOT NULL, qte INT NOT NULL, commande_status LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', date_commande DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, livreur_id_id INT DEFAULT NULL, commande_id INT NOT NULL, reservation_type VARCHAR(255) NOT NULL, date_reservation DATETIME NOT NULL, nombre_personne INT DEFAULT NULL, INDEX IDX_42C849557E0F7DE (livreur_id_id), INDEX IDX_42C8495582EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849557E0F7DE FOREIGN KEY (livreur_id_id) REFERENCES livreur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495582EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE employe ADD author_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B969CCBE9A FOREIGN KEY (author_id_id) REFERENCES blog (id)');
        $this->addSql('CREATE INDEX IDX_F804D3B969CCBE9A ON employe (author_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B969CCBE9A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849557E0F7DE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495582EA2E54');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP INDEX IDX_F804D3B969CCBE9A ON employe');
        $this->addSql('ALTER TABLE employe DROP author_id_id');
    }
}
