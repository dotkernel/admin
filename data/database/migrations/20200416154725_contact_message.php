<?php

use Phinx\Migration\AbstractMigration;

class ContactMessage extends AbstractMigration
{
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
        $this->table('contact_message', ['id' => false, 'primary_key' => 'uuid', 'collation' => 'utf8mb4_general_ci'])
            ->addColumn('uuid', 'binary', ['limit' => 16])
            ->addColumn('email', 'string', ['limit' => 150])
            ->addColumn('name', 'string', ['limit' => 150])
            ->addColumn('subject', 'text')
            ->addColumn('message', 'text')
            ->addColumn(
                'platform',
                'enum',
                [
                    'values' => [
                        'website',
                        'designer',
                        'admin'
                    ],
                    'default' => 'website'
                ]
            )
            ->addTimestamps('created', 'updated')
            ->addIndex(['email'])
            ->create();
    }
}
