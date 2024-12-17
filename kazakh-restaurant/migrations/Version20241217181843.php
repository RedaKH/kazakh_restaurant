<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241217181843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_history ADD entree VARCHAR(255) NOT NULL, ADD qte_entree INT NOT NULL, ADD qte_plat INT NOT NULL, ADD boisson VARCHAR(255) NOT NULL, ADD qte_boisson INT NOT NULL, ADD dessert VARCHAR(255) NOT NULL, ADD qte_dessert INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_history DROP entree, DROP qte_entree, DROP qte_plat, DROP boisson, DROP qte_boisson, DROP dessert, DROP qte_dessert');
    }
}
