<?php

declare(strict_types=1);

namespace Admin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028094056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the default database structure.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary_ordered_time)\', identity VARCHAR(100) NOT NULL, firstName VARCHAR(255) NOT NULL, lastName VARCHAR(255) NOT NULL, password VARCHAR(100) NOT NULL, status ENUM(\'pending\', \'active\'), created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_880E0D766A95E9C4 (identity), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_roles (userUuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary_ordered_time)\', roleUuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary_ordered_time)\', INDEX IDX_1614D53DD73087E9 (userUuid), INDEX IDX_1614D53D88446210 (roleUuid), PRIMARY KEY(userUuid, roleUuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_login (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary_ordered_time)\', adminIp VARCHAR(50) DEFAULT NULL, country VARCHAR(50) DEFAULT NULL, continent VARCHAR(50) DEFAULT NULL, organization VARCHAR(50) DEFAULT NULL, deviceType VARCHAR(20) DEFAULT NULL, deviceBrand VARCHAR(20) DEFAULT NULL, deviceModel VARCHAR(40) DEFAULT NULL, isMobile ENUM(\'yes\', \'no\'), osName VARCHAR(20) DEFAULT NULL, osVersion VARCHAR(20) DEFAULT NULL, osPlatform VARCHAR(20) DEFAULT NULL, clientType VARCHAR(20) DEFAULT NULL, clientName VARCHAR(40) DEFAULT NULL, clientEngine VARCHAR(20) DEFAULT NULL, clientVersion VARCHAR(20) DEFAULT NULL, loginStatus ENUM(\'success\', \'fail\'), identity VARCHAR(100) NOT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_role (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary_ordered_time)\', name VARCHAR(30) NOT NULL, created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_7770088A5E237E06 (name), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin_roles ADD CONSTRAINT FK_1614D53DD73087E9 FOREIGN KEY (userUuid) REFERENCES admin (uuid)');
        $this->addSql('ALTER TABLE admin_roles ADD CONSTRAINT FK_1614D53D88446210 FOREIGN KEY (roleUuid) REFERENCES admin_role (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_roles DROP FOREIGN KEY FK_1614D53DD73087E9');
        $this->addSql('ALTER TABLE admin_roles DROP FOREIGN KEY FK_1614D53D88446210');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE admin_roles');
        $this->addSql('DROP TABLE admin_login');
        $this->addSql('DROP TABLE admin_role');
    }
}
