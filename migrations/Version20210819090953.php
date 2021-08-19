<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819090953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F181A8BA');
        $this->addSql('DROP INDEX IDX_AF86866F181A8BA ON offre');
        $this->addSql('ALTER TABLE offre CHANGE voiture_id voiture_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F52E93BA0 FOREIGN KEY (voiture_id_id) REFERENCES voiture (id)');
        $this->addSql('CREATE INDEX IDX_AF86866F52E93BA0 ON offre (voiture_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F52E93BA0');
        $this->addSql('DROP INDEX IDX_AF86866F52E93BA0 ON offre');
        $this->addSql('ALTER TABLE offre CHANGE voiture_id_id voiture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('CREATE INDEX IDX_AF86866F181A8BA ON offre (voiture_id)');
    }
}
