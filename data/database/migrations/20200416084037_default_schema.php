<?php

use Phinx\Migration\AbstractMigration;
use Frontend\User\Entity\User;
use Frontend\User\Entity\UserResetPassword;

class DefaultSchema extends AbstractMigration
{
    protected array $fkCascade = ['delete' => 'CASCADE', 'update' => 'CASCADE'];

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('user', ['id' => false, 'primary_key' => 'uuid', 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('uuid', 'binary', ['null' => false, 'limit' => 16])
            ->addColumn('identity', 'string', ['null' => false, 'limit' => 100])
            ->addColumn('password', 'string', ['null' => false, 'limit' => 100])
            ->addColumn('status', 'enum',
                [
                    'default' => User::STATUS_PENDING,
                    'values' => User::STATUSES
                ]
            )
            ->addColumn('isDeleted', 'enum',
                [
                    'default' => User::IS_DELETED_NO,
                    'values' => [User::IS_DELETED_YES, User::IS_DELETED_NO]
                ]
            )
            ->addColumn('hash', 'string', ['null' => false, 'limit' => 100])
            ->addTimestamps('created', 'updated')
            ->addIndex(['identity'], ['name' => 'identity', 'unique' => true])
            ->create();

        $this->table('user_detail', ['id' => false, 'primary_key' => 'uuid', 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('uuid', 'binary', ['null' => false, 'limit' => 16])
            ->addColumn('userUuid', 'binary', ['null' => false, 'limit' => 16])
            ->addColumn('firstName', 'string', ['null' => true, 'limit' => 255])
            ->addColumn('lastName', 'string', ['null' => true, 'limit' => 255])
            ->addTimestamps('created', 'updated')
            ->addForeignKey('userUuid', 'user', 'uuid', $this->fkCascade)
            ->create();

        $this->table('user_avatar', ['id' => false, 'primary_key' => 'uuid', 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('uuid', 'binary', ['null' => false, 'limit' => 16])
            ->addColumn('userUuid', 'binary', ['null' => false, 'limit' => 16])
            ->addColumn('name', 'string', ['null' => false, 'limit' => 255])
            ->addTimestamps('created', 'updated')
            ->addForeignKey('userUuid', 'user', 'uuid', $this->fkCascade)
            ->create();

        $this->table('user_role', ['id' => false, 'primary_key' => 'uuid', 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('uuid', 'binary', ['null' => false, 'limit' => 16])
            ->addColumn('name', 'string', ['null' => false, 'limit' => 150])
            ->addTimestamps('created', 'updated')
            ->addIndex(['name'], ['name' => 'name', 'unique' => true])
            ->create();

        $this->table('user_roles', ['id' => false, 'primary_key' => ['userUuid', 'roleUuid'], 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('userUuid', 'binary', ['null' => false, 'limit' => 16])
            ->addColumn('roleUuid', 'binary', ['null' => false, 'limit' => 16])
            ->addTimestamps('created', 'updated')
            ->addForeignKey('userUuid', 'user', 'uuid', $this->fkCascade)
            ->addForeignKey('roleUuid', 'user_role', 'uuid', $this->fkCascade)
            ->create();

        $this->table('user_reset_password', ['id' => false, 'primary_key' => 'uuid', 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('uuid', 'binary', ['null' => false, 'limit' => 16])
            ->addColumn('userUuid', 'binary', ['null' => true, 'limit' => 16])
            ->addColumn('hash', 'string', ['null' => false, 'limit' => 100])
            ->addColumn(
                'status',
                'enum', [
                    'null' => false,
                    'default' => UserResetPassword::STATUS_REQUESTED,
                    'values' => UserResetPassword::STATUSES
                ]
            )
            ->addColumn('expires', 'timestamp', ['null' => true])
            ->addTimestamps('created', 'updated')
            ->addIndex(['userUuid'], ['unique' => false])
            ->addIndex(['hash'], ['unique' => true])
            ->addForeignKey('userUuid', 'user', 'uuid', $this->fkCascade)
            ->create();
    }
}
