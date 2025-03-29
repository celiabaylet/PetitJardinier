<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107094245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tailler ADD haie_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tailler ADD CONSTRAINT FK_447D1788E7470F2C FOREIGN KEY (haie_id) REFERENCES haie (code)');
        $this->addSql('CREATE INDEX IDX_447D1788E7470F2C ON tailler (haie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tailler DROP FOREIGN KEY FK_447D1788E7470F2C');
        $this->addSql('DROP INDEX IDX_447D1788E7470F2C ON tailler');
        $this->addSql('ALTER TABLE tailler DROP haie_id');
    }
}
