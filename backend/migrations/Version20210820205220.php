<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210820205220 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE oauth_auth_codes (id VARCHAR(255) NOT NULL, expiry_date_time DATE NOT NULL, user_identifier VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN oauth_auth_codes.expiry_date_time IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE oauth_refresh_tokens (id VARCHAR(255) NOT NULL, expiry_date_time DATE NOT NULL, user_identifier VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN oauth_refresh_tokens.expiry_date_time IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE fan_profiles ALTER address_address SET NOT NULL');
        $this->addSql('ALTER TABLE fan_profiles ALTER phone_number SET NOT NULL');
        $this->addSql('ALTER TABLE musician_profiles ALTER address_address SET NOT NULL');
        $this->addSql('ALTER TABLE musician_profiles ALTER phone_number SET NOT NULL');
        $this->addSql('ALTER TABLE users DROP annual_auth_token');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE oauth_auth_codes');
        $this->addSql('DROP TABLE oauth_refresh_tokens');
        $this->addSql('ALTER TABLE fan_profiles ALTER address_address DROP NOT NULL');
        $this->addSql('ALTER TABLE fan_profiles ALTER phone_number DROP NOT NULL');
        $this->addSql('ALTER TABLE musician_profiles ALTER address_address DROP NOT NULL');
        $this->addSql('ALTER TABLE musician_profiles ALTER phone_number DROP NOT NULL');
        $this->addSql('ALTER TABLE users ADD annual_auth_token VARCHAR(255) NOT NULL');
    }
}
