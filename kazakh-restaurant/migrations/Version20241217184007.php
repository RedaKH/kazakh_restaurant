<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217184007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_history CHANGE plat plat VARCHAR(255) DEFAULT NULL, CHANGE entree entree VARCHAR(255) DEFAULT NULL, CHANGE qte_entree qte_entree INT DEFAULT NULL, CHANGE qte_plat qte_plat INT DEFAULT NULL, CHANGE boisson boisson VARCHAR(255) DEFAULT NULL, CHANGE qte_boisson qte_boisson INT DEFAULT NULL, CHANGE dessert dessert VARCHAR(255) DEFAULT NULL, CHANGE qte_dessert qte_dessert INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_history CHANGE plat plat VARCHAR(255) NOT NULL, CHANGE entree entree VARCHAR(255) NOT NULL, CHANGE qte_entree qte_entree INT NOT NULL, CHANGE qte_plat qte_plat INT NOT NULL, CHANGE boisson boisson VARCHAR(255) NOT NULL, CHANGE qte_boisson qte_boisson INT NOT NULL, CHANGE dessert dessert VARCHAR(255) NOT NULL, CHANGE qte_dessert qte_dessert INT NOT NULL');
    }
}
