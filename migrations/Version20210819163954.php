<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819163954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture CHANGE description description LONGTEXT DEFAULT NULL, CHANGE image image VARCHAR(1000) DEFAULT NULL, CHANGE prix_demande prix_demande INT DEFAULT NULL, CHANGE mise_en_vente mise_en_vente DATETIME DEFAULT NULL, CHANGE kilometrage kilometrage INT DEFAULT NULL, CHANGE Cylindree cylindree INT DEFAULT NULL, CHANGE annee_de_mise_en_circulation annee_de_mise_en_circulation INT DEFAULT NULL, CHANGE modele modele VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture CHANGE prix_demande prix_demande INT NOT NULL, CHANGE image image VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE kilometrage kilometrage INT NOT NULL, CHANGE cylindree Cylindree INT NOT NULL, CHANGE description description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mise_en_vente mise_en_vente DATETIME NOT NULL, CHANGE annee_de_mise_en_circulation annee_de_mise_en_circulation INT NOT NULL, CHANGE modele modele VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
