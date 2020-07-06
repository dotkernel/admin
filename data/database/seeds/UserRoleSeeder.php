<?php

namespace Data\Database\Seeds;

use Phinx\Seed\AbstractSeed;
use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;

class UserRoleSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @throws \Exception
     */
    public function run()
    {
        $uuidFactory = $this->getUuidGenerator();
        $userRoles = $this->fetchAll('SELECT * FROM `user_role`');

        if (empty($userRoles)) {
            $role = $this->table('user_role');
            $role->insert(
                [
                    [
                        'uuid' => $uuidFactory->uuid1()->getBytes(),
                        'name' => 'user'
                    ],
                    [
                        'uuid' => $uuidFactory->uuid1()->getBytes(),
                        'name' => 'guest'
                    ],
                ]
            )->save();
        }
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
