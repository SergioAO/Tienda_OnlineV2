<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605212138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario CHANGE email email VARCHAR(180) NOT NULL, CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX uniq_2265b05de7927c74 ON usuario');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON usuario (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario CHANGE email email VARCHAR(50) DEFAULT NULL, CHANGE roles roles INT NOT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX uniq_identifier_email ON usuario');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DE7927C74 ON usuario (email)');
    }
}
