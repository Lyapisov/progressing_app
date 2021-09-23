<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210814133243 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE fan_profiles (id VARCHAR(255) NOT NULL, user_id VARCHAR(255) NOT NULL, birthday DATE NOT NULL, favorite_musician_ids TEXT NOT NULL, name_login VARCHAR(255) NOT NULL, name_first_name VARCHAR(255) NOT NULL, name_last_name VARCHAR(255) DEFAULT NULL, name_father_name VARCHAR(255) DEFAULT NULL, address_address VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN fan_profiles.birthday IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN fan_profiles.favorite_musician_ids IS \'(DC2Type:simple_array)\'');
        $this->addSql('CREATE TABLE musician_profiles (id VARCHAR(255) NOT NULL, user_id VARCHAR(255) NOT NULL, birthday DATE NOT NULL, favorite_musician_ids TEXT NOT NULL, name_login VARCHAR(255) NOT NULL, name_first_name VARCHAR(255) NOT NULL, name_last_name VARCHAR(255) DEFAULT NULL, name_father_name VARCHAR(255) DEFAULT NULL, address_address VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN musician_profiles.birthday IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN musician_profiles.favorite_musician_ids IS \'(DC2Type:simple_array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE fan_profiles');
        $this->addSql('DROP TABLE musician_profiles');
    }
}
