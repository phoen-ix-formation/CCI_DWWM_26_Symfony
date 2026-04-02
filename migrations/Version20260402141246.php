<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260402141246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokemon_pokemon_types (ppt_pkm_id INT NOT NULL, ppt_pkt_id INT NOT NULL, PRIMARY KEY (ppt_pkm_id, ppt_pkt_id))');
        $this->addSql('CREATE INDEX IDX_4997DD6FAD6B506E ON pokemon_pokemon_types (ppt_pkm_id)');
        $this->addSql('CREATE INDEX IDX_4997DD6F807A487B ON pokemon_pokemon_types (ppt_pkt_id)');
        $this->addSql('ALTER TABLE pokemon_pokemon_types ADD CONSTRAINT FK_4997DD6FAD6B506E FOREIGN KEY (ppt_pkm_id) REFERENCES pokemons (pkm_id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE pokemon_pokemon_types ADD CONSTRAINT FK_4997DD6F807A487B FOREIGN KEY (ppt_pkt_id) REFERENCES pokemon_types (pkt_id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokemon_pokemon_types DROP CONSTRAINT FK_4997DD6FAD6B506E');
        $this->addSql('ALTER TABLE pokemon_pokemon_types DROP CONSTRAINT FK_4997DD6F807A487B');
        $this->addSql('DROP TABLE pokemon_pokemon_types');
    }
}
