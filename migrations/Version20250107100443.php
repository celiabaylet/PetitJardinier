<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107100443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tailler ADD devis_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tailler ADD CONSTRAINT FK_447D178841DEFADA FOREIGN KEY (devis_id) REFERENCES devis (no)');
        $this->addSql('CREATE INDEX IDX_447D178841DEFADA ON tailler (devis_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tailler DROP FOREIGN KEY FK_447D178841DEFADA');
        $this->addSql('DROP INDEX IDX_447D178841DEFADA ON tailler');
        $this->addSql('ALTER TABLE tailler DROP devis_id');
    }
}
