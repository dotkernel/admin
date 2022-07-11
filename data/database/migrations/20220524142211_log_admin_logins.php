<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Frontend\Admin\Entity\AdminLogin;

/**
 * ClassLogAdminLogins
 */
final class LogAdminLogins extends AbstractMigration
{
    protected string $adminLogin = 'admin_login';
    protected array $fkCascade = ['delete' => 'CASCADE', 'update' => 'CASCADE'];

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table(
            $this->adminLogin,
            ['id' => false, 'primary_key' => ['uuid'], 'collation' => 'utf8mb4_general_ci']
        )
            ->addColumn('uuid', 'binary', ['null' => false, 'limit' => 16])
            ->addColumn('adminIp', 'string', ['null' => false, 'default' => null,'limit' => 100])
            ->addColumn('identity', 'string', ['null' => false, 'default' => null,'limit' => 100])
            ->addColumn('country', 'string', ['null' => true, 'default' => null,'limit' => 50])
            ->addColumn('continent', 'string', ['null' => true, 'default' => null,'limit' => 50])
            ->addColumn('organization', 'string', ['null' => true, 'default' => null,'limit' => 50])
            ->addColumn('deviceType', 'string', ['null' => true, 'default' => null, 'limit' => 20])
            ->addColumn('deviceBrand', 'string', ['null' => true, 'default' => null, 'limit' => 20])
            ->addColumn('deviceModel', 'string', ['null' => true, 'default' => null, 'limit' => 40])
            ->addColumn(
                'isMobile',
                'enum',
                [
                    'null' => true,
                    'default' => null,
                    'values' => [AdminLogin::IS_MOBILE_YES, AdminLogin::IS_MOBILE_NO]
                ]
            )
            ->addColumn(
                'loginStatus',
                'enum',
                [
                    'null' => true,
                    'default' => null,
                    'values' => [AdminLogin::LOGIN_SUCCESS, AdminLogin::LOGIN_FAIL]
                ]
            )
            ->addColumn('osName', 'string', ['null' => true, 'default' => null, 'limit' => 20])
            ->addColumn('osVersion', 'string', ['null' => true, 'default' => null, 'limit' => 20])
            ->addColumn('osPlatform', 'string', ['null' => true, 'default' => null, 'limit' => 20])
            ->addColumn('clientType', 'string', ['null' => true, 'default' => null,'limit' => 20])
            ->addColumn('clientName', 'string', ['null' => true, 'default' => null, 'limit' => 40])
            ->addColumn('clientEngine', 'string', ['null' => true, 'default' => null, 'limit' => 20])
            ->addColumn('clientVersion', 'string', ['null' => true, 'default' => null, 'limit' => 20])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated', 'timestamp', ['null' => true])
            ->create();
    }
}
