<?php
namespace Data\Database\Seeds;

use Frontend\User\Entity\Admin;
use Phinx\Seed\AbstractSeed;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;

class AdminSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $adminTable = $this->table('admin');
        $adminRoleTable = $this->table('admin_role');
        $adminRolesTable = $this->table('admin_roles');

        $superUserUuid = $this->getUuidGenerator()->uuid1()->getBytes();
        $adminUuid = $this->getUuidGenerator()->uuid1()->getBytes();

        $roles = [
            [
                'uuid' => $superUserUuid,
                'name' => 'superuser'
            ],
            [
                'uuid' => $adminUuid,
                'name' => 'admin'
            ]
        ];

        $adminUuid = $this->getUuidGenerator()->uuid1()->getBytes();

        $admin = [
            'uuid' => $adminUuid,
            'identity' => 'admin',
            'password' => '$2y$11$OwMimRB1aTrv.VH0uRIDFeU3eh7NNraKncCRruhW.lKOPyz/R7Fq6',
            'firstName' => 'DotKernel',
            'lastName' => 'Admin',
            'status' => Admin::STATUS_ACTIVE
        ];

        $adminRoles = [
            'userUuid' => $adminUuid,
            'roleUuid' => $superUserUuid
        ];

        $adminRoleTable->insert($roles)->save();
        $adminTable->insert($admin)->save();
        $adminRolesTable->insert($adminRoles)->save();
    }

    /**
     * @return UuidFactory
     */
    protected function getUuidGenerator()
    {
        /** @var UuidFactory $factory */
        $factory = clone Uuid::getFactory();
        $codec = new OrderedTimeCodec($factory->getUuidBuilder());
        $factory->setCodec($codec);

        return $factory;
    }
}
