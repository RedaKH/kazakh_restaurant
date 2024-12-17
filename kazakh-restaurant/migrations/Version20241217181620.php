<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217181620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE livreur');
        $this->addSql('ALTER TABLE reservation ADD qte_entree INT NOT NULL, ADD qte_plat INT NOT NULL, ADD qte_boisson INT NOT NULL, ADD qte_dessert INT NOT NULL, DROP quantite_entree, DROP quantite_dessert, DROP quantite_boisson, DROP quantite_plat, CHANGE entree entree VARCHAR(255) NOT NULL, CHANGE dessert dessert VARCHAR(255) NOT NULL, CHANGE boisson boisson VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservation ADD quantite_entree INT DEFAULT NULL, ADD quantite_dessert INT DEFAULT NULL, ADD quantite_boisson INT DEFAULT NULL, ADD quantite_plat INT DEFAULT NULL, DROP qte_entree, DROP qte_plat, DROP qte_boisson, DROP qte_dessert, CHANGE entree entree VARCHAR(255) DEFAULT NULL, CHANGE boisson boisson VARCHAR(255) DEFAULT NULL, CHANGE dessert dessert VARCHAR(255) DEFAULT NULL');
    }
}
