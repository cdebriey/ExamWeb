<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210820074356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, voiture_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse_email VARCHAR(255) DEFAULT NULL, prix_offert INT NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_AF86866F181A8BA (voiture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, marque VARCHAR(255) NOT NULL, prix_demande INT NOT NULL, image VARCHAR(1000) NOT NULL, kilometrage INT NOT NULL, cylindree INT NOT NULL, description LONGTEXT NOT NULL, mise_en_vente DATETIME NOT NULL, annee_de_mise_en_circulation INT DEFAULT NULL, modele VARCHAR(255) DEFAULT NULL, puissance INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F181A8BA');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE voiture');
    }
}
