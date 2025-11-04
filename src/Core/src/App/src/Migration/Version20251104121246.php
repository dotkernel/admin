<?php

declare(strict_types=1);

namespace Core\App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251104121246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dk_admin (identity VARCHAR(191) NOT NULL, firstName VARCHAR(191) DEFAULT NULL, lastName VARCHAR(191) DEFAULT NULL, password VARCHAR(191) NOT NULL, status ENUM(\'active\', \'inactive\') DEFAULT \'active\' NOT NULL, uuid BINARY(16) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_BC6297E6A95E9C4 (identity), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_admin_roles (userUuid BINARY(16) NOT NULL, roleUuid BINARY(16) NOT NULL, INDEX IDX_9E8CBDA4D73087E9 (userUuid), INDEX IDX_9E8CBDA488446210 (roleUuid), PRIMARY KEY (userUuid, roleUuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_admin_login (identity VARCHAR(191) DEFAULT NULL, adminIp VARCHAR(191) DEFAULT NULL, country VARCHAR(191) DEFAULT NULL, continent VARCHAR(191) DEFAULT NULL, organization VARCHAR(191) DEFAULT NULL, deviceType VARCHAR(191) DEFAULT NULL, deviceBrand VARCHAR(191) DEFAULT NULL, deviceModel VARCHAR(40) DEFAULT NULL, isMobile ENUM(\'yes\', \'no\') DEFAULT NULL, osName VARCHAR(191) DEFAULT NULL, osVersion VARCHAR(191) DEFAULT NULL, osPlatform VARCHAR(191) DEFAULT NULL, clientType VARCHAR(191) DEFAULT NULL, clientName VARCHAR(191) DEFAULT NULL, clientEngine VARCHAR(191) DEFAULT NULL, clientVersion VARCHAR(191) DEFAULT NULL, loginStatus ENUM(\'success\', \'fail\') DEFAULT NULL, uuid BINARY(16) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_admin_role (name ENUM(\'admin\', \'superuser\') DEFAULT \'admin\' NOT NULL, uuid BINARY(16) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_E74277525E237E06 (name), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_oauth_access_tokens (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id VARCHAR(25) DEFAULT NULL, token VARCHAR(100) NOT NULL, revoked TINYINT(1) DEFAULT 0 NOT NULL, expires_at DATETIME NOT NULL, client_id INT UNSIGNED DEFAULT NULL, INDEX IDX_3277905919EB6921 (client_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_oauth_access_token_scopes (access_token_id INT UNSIGNED NOT NULL, scope_id INT UNSIGNED NOT NULL, INDEX IDX_2749672C2CCB2688 (access_token_id), INDEX IDX_2749672C682B5931 (scope_id), PRIMARY KEY (access_token_id, scope_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_oauth_auth_codes (id INT UNSIGNED AUTO_INCREMENT NOT NULL, revoked TINYINT(1) DEFAULT 0 NOT NULL, expiresDatetime DATETIME DEFAULT NULL, client_id INT UNSIGNED DEFAULT NULL, INDEX IDX_99975E0519EB6921 (client_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_oauth_auth_code_scopes (auth_code_id INT UNSIGNED NOT NULL, scope_id INT UNSIGNED NOT NULL, INDEX IDX_9720AA369FEDEE4 (auth_code_id), INDEX IDX_9720AA3682B5931 (scope_id), PRIMARY KEY (auth_code_id, scope_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_oauth_clients (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, secret VARCHAR(100) DEFAULT NULL, redirect VARCHAR(191) NOT NULL, revoked TINYINT(1) DEFAULT 0 NOT NULL, isConfidential TINYINT(1) DEFAULT 0 NOT NULL, user_id BINARY(16) DEFAULT NULL, INDEX IDX_F024D1A0A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_oauth_refresh_tokens (id INT UNSIGNED AUTO_INCREMENT NOT NULL, revoked TINYINT(1) DEFAULT 0 NOT NULL, expires_at DATETIME NOT NULL, access_token_id INT UNSIGNED DEFAULT NULL, INDEX IDX_4BA657022CCB2688 (access_token_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_oauth_scopes (id INT UNSIGNED AUTO_INCREMENT NOT NULL, scope VARCHAR(191) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_settings (identifier ENUM(\'table_admin_list_selected_columns\', \'table_admin_list_logins_selected_columns\', \'table_user_list_selected_columns\') NOT NULL, value LONGTEXT NOT NULL, uuid BINARY(16) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, admin_uuid BINARY(16) DEFAULT NULL, INDEX IDX_8F015ADAF166D246 (admin_uuid), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_user (identity VARCHAR(191) NOT NULL, password VARCHAR(191) NOT NULL, status ENUM(\'active\', \'pending\', \'deleted\') DEFAULT \'pending\' NOT NULL, hash VARCHAR(191) NOT NULL, uuid BINARY(16) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_9632195E6A95E9C4 (identity), UNIQUE INDEX UNIQ_9632195ED1B862B8 (hash), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_user_roles (userUuid BINARY(16) NOT NULL, roleUuid BINARY(16) NOT NULL, INDEX IDX_C4CEAA47D73087E9 (userUuid), INDEX IDX_C4CEAA4788446210 (roleUuid), PRIMARY KEY (userUuid, roleUuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_user_avatar (name VARCHAR(191) NOT NULL, uuid BINARY(16) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, userUuid BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_FBBD018BD73087E9 (userUuid), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_user_detail (firstName VARCHAR(191) DEFAULT NULL, lastName VARCHAR(191) DEFAULT NULL, email VARCHAR(191) NOT NULL, uuid BINARY(16) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, userUuid BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_C3CC0C37D73087E9 (userUuid), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_user_reset_password (expires DATETIME NOT NULL, hash VARCHAR(191) NOT NULL, status ENUM(\'completed\', \'requested\') DEFAULT \'requested\' NOT NULL, uuid BINARY(16) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, userUuid BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_2A282199D1B862B8 (hash), INDEX IDX_2A282199D73087E9 (userUuid), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dk_user_role (name ENUM(\'guest\', \'user\') DEFAULT \'user\' NOT NULL, uuid BINARY(16) NOT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A08A8FAC5E237E06 (name), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dk_admin_roles ADD CONSTRAINT FK_9E8CBDA4D73087E9 FOREIGN KEY (userUuid) REFERENCES dk_admin (uuid)');
        $this->addSql('ALTER TABLE dk_admin_roles ADD CONSTRAINT FK_9E8CBDA488446210 FOREIGN KEY (roleUuid) REFERENCES dk_admin_role (uuid)');
        $this->addSql('ALTER TABLE dk_oauth_access_tokens ADD CONSTRAINT FK_3277905919EB6921 FOREIGN KEY (client_id) REFERENCES dk_oauth_clients (id)');
        $this->addSql('ALTER TABLE dk_oauth_access_token_scopes ADD CONSTRAINT FK_2749672C2CCB2688 FOREIGN KEY (access_token_id) REFERENCES dk_oauth_access_tokens (id)');
        $this->addSql('ALTER TABLE dk_oauth_access_token_scopes ADD CONSTRAINT FK_2749672C682B5931 FOREIGN KEY (scope_id) REFERENCES dk_oauth_scopes (id)');
        $this->addSql('ALTER TABLE dk_oauth_auth_codes ADD CONSTRAINT FK_99975E0519EB6921 FOREIGN KEY (client_id) REFERENCES dk_oauth_clients (id)');
        $this->addSql('ALTER TABLE dk_oauth_auth_code_scopes ADD CONSTRAINT FK_9720AA369FEDEE4 FOREIGN KEY (auth_code_id) REFERENCES dk_oauth_auth_codes (id)');
        $this->addSql('ALTER TABLE dk_oauth_auth_code_scopes ADD CONSTRAINT FK_9720AA3682B5931 FOREIGN KEY (scope_id) REFERENCES dk_oauth_scopes (id)');
        $this->addSql('ALTER TABLE dk_oauth_clients ADD CONSTRAINT FK_F024D1A0A76ED395 FOREIGN KEY (user_id) REFERENCES dk_user (uuid)');
        $this->addSql('ALTER TABLE dk_oauth_refresh_tokens ADD CONSTRAINT FK_4BA657022CCB2688 FOREIGN KEY (access_token_id) REFERENCES dk_oauth_access_tokens (id)');
        $this->addSql('ALTER TABLE dk_settings ADD CONSTRAINT FK_8F015ADAF166D246 FOREIGN KEY (admin_uuid) REFERENCES dk_admin (uuid)');
        $this->addSql('ALTER TABLE dk_user_roles ADD CONSTRAINT FK_C4CEAA47D73087E9 FOREIGN KEY (userUuid) REFERENCES dk_user (uuid)');
        $this->addSql('ALTER TABLE dk_user_roles ADD CONSTRAINT FK_C4CEAA4788446210 FOREIGN KEY (roleUuid) REFERENCES dk_user_role (uuid)');
        $this->addSql('ALTER TABLE dk_user_avatar ADD CONSTRAINT FK_FBBD018BD73087E9 FOREIGN KEY (userUuid) REFERENCES dk_user (uuid)');
        $this->addSql('ALTER TABLE dk_user_detail ADD CONSTRAINT FK_C3CC0C37D73087E9 FOREIGN KEY (userUuid) REFERENCES dk_user (uuid)');
        $this->addSql('ALTER TABLE dk_user_reset_password ADD CONSTRAINT FK_2A282199D73087E9 FOREIGN KEY (userUuid) REFERENCES dk_user (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dk_admin_roles DROP FOREIGN KEY FK_9E8CBDA4D73087E9');
        $this->addSql('ALTER TABLE dk_admin_roles DROP FOREIGN KEY FK_9E8CBDA488446210');
        $this->addSql('ALTER TABLE dk_oauth_access_tokens DROP FOREIGN KEY FK_3277905919EB6921');
        $this->addSql('ALTER TABLE dk_oauth_access_token_scopes DROP FOREIGN KEY FK_2749672C2CCB2688');
        $this->addSql('ALTER TABLE dk_oauth_access_token_scopes DROP FOREIGN KEY FK_2749672C682B5931');
        $this->addSql('ALTER TABLE dk_oauth_auth_codes DROP FOREIGN KEY FK_99975E0519EB6921');
        $this->addSql('ALTER TABLE dk_oauth_auth_code_scopes DROP FOREIGN KEY FK_9720AA369FEDEE4');
        $this->addSql('ALTER TABLE dk_oauth_auth_code_scopes DROP FOREIGN KEY FK_9720AA3682B5931');
        $this->addSql('ALTER TABLE dk_oauth_clients DROP FOREIGN KEY FK_F024D1A0A76ED395');
        $this->addSql('ALTER TABLE dk_oauth_refresh_tokens DROP FOREIGN KEY FK_4BA657022CCB2688');
        $this->addSql('ALTER TABLE dk_settings DROP FOREIGN KEY FK_8F015ADAF166D246');
        $this->addSql('ALTER TABLE dk_user_roles DROP FOREIGN KEY FK_C4CEAA47D73087E9');
        $this->addSql('ALTER TABLE dk_user_roles DROP FOREIGN KEY FK_C4CEAA4788446210');
        $this->addSql('ALTER TABLE dk_user_avatar DROP FOREIGN KEY FK_FBBD018BD73087E9');
        $this->addSql('ALTER TABLE dk_user_detail DROP FOREIGN KEY FK_C3CC0C37D73087E9');
        $this->addSql('ALTER TABLE dk_user_reset_password DROP FOREIGN KEY FK_2A282199D73087E9');
        $this->addSql('DROP TABLE dk_admin');
        $this->addSql('DROP TABLE dk_admin_roles');
        $this->addSql('DROP TABLE dk_admin_login');
        $this->addSql('DROP TABLE dk_admin_role');
        $this->addSql('DROP TABLE dk_oauth_access_tokens');
        $this->addSql('DROP TABLE dk_oauth_access_token_scopes');
        $this->addSql('DROP TABLE dk_oauth_auth_codes');
        $this->addSql('DROP TABLE dk_oauth_auth_code_scopes');
        $this->addSql('DROP TABLE dk_oauth_clients');
        $this->addSql('DROP TABLE dk_oauth_refresh_tokens');
        $this->addSql('DROP TABLE dk_oauth_scopes');
        $this->addSql('DROP TABLE dk_settings');
        $this->addSql('DROP TABLE dk_user');
        $this->addSql('DROP TABLE dk_user_roles');
        $this->addSql('DROP TABLE dk_user_avatar');
        $this->addSql('DROP TABLE dk_user_detail');
        $this->addSql('DROP TABLE dk_user_reset_password');
        $this->addSql('DROP TABLE dk_user_role');
    }
}
