<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726132205 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE publications (id VARCHAR(255) NOT NULL, author_id VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', content_title VARCHAR(255) NOT NULL, content_text LONGTEXT NOT NULL, content_image_id VARCHAR(255) NOT NULL, likes_authors JSON NOT NULL, likes_count INT NOT NULL, status_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publications_author (id VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, role_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profiles_fan ADD personal_data_name_last VARCHAR(255) DEFAULT NULL, ADD personal_data_name_father VARCHAR(255) DEFAULT NULL, DROP personal_data_name_last_name, DROP personal_data_name_father_name, CHANGE personal_data_name_first_name personal_data_name_first VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE profiles_musician ADD personal_data_name_last VARCHAR(255) DEFAULT NULL, ADD personal_data_name_father VARCHAR(255) DEFAULT NULL, DROP personal_data_name_last_name, DROP personal_data_name_father_name, CHANGE personal_data_name_first_name personal_data_name_first VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE profiles_producer ADD personal_data_name_last VARCHAR(255) DEFAULT NULL, ADD personal_data_name_father VARCHAR(255) DEFAULT NULL, DROP personal_data_name_last_name, DROP personal_data_name_father_name, CHANGE personal_data_name_first_name personal_data_name_first VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE publications');
        $this->addSql('DROP TABLE publications_author');
        $this->addSql('ALTER TABLE profiles_fan ADD personal_data_name_last_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD personal_data_name_father_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP personal_data_name_last, DROP personal_data_name_father, CHANGE personal_data_name_first personal_data_name_first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE profiles_musician ADD personal_data_name_last_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD personal_data_name_father_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP personal_data_name_last, DROP personal_data_name_father, CHANGE personal_data_name_first personal_data_name_first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE profiles_producer ADD personal_data_name_last_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD personal_data_name_father_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP personal_data_name_last, DROP personal_data_name_father, CHANGE personal_data_name_first personal_data_name_first_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
