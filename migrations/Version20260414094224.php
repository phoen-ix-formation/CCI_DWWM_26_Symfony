<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260414094224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures ADD pct_pkm_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC038262EDA FOREIGN KEY (pct_pkm_id) REFERENCES pokemons (pkm_id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_8F7C2FC038262EDA ON pictures (pct_pkm_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures DROP CONSTRAINT FK_8F7C2FC038262EDA');
        $this->addSql('DROP INDEX IDX_8F7C2FC038262EDA');
        $this->addSql('ALTER TABLE pictures DROP pct_pkm_id');
    }
}
