<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 2/28/2017
 * Time: 7:59 PM
 */

declare(strict_types = 1);

namespace Admin\User\Mapper;

use Admin\App\Mapper\SearchFinderMapperTrait;
use Admin\User\Entity\UserDetailsEntity;
use Admin\User\Entity\UserEntity;
use Dot\Mapper\Event\MapperEvent;
use Dot\Mapper\Mapper\MapperManager;
use Dot\Hydrator\ClassMethodsCamelCase;
use Zend\Db\Metadata\Object\ColumnObject;
use Zend\Db\Sql\Select;
use Zend\Hydrator\HydratorInterface;

/**
 * Class UserDbMapper
 * @package Admin\User\Mapper
 */
class UserDbMapper extends \Dot\User\Mapper\UserDbMapper
{
    use SearchFinderMapperTrait;

    /** @var string  */
    protected $userDetailsTable = 'user_details';

    /** @var  UserDetailsEntity */
    protected $userDetailsPrototype;

    /** @var  HydratorInterface */
    protected $userDetailsHydrator;

    /** @var  array */
    protected $detailsColumns;

    /**
     * UserDbMapper constructor.
     * @param MapperManager $mapperManager
     * @param array $options
     */
    public function __construct(MapperManager $mapperManager, array $options = [])
    {
        parent::__construct($mapperManager, $options);

        $this->userDetailsPrototype = new UserDetailsEntity();
        $this->userDetailsHydrator = new ClassMethodsCamelCase();
    }

    /**
     * The user details join is dependent, and we add it on every user find
     *
     * @param string $type
     * @param array $options
     * @return array
     */
    public function find(string $type = 'all', array $options = []): array
    {
        $this->insertUserDetailsJoin($options);
        return parent::find($type, $options);
    }

    /**
     * We override the count select too, in order to add the join
     *
     * @param string $type
     * @param array $options
     * @return int
     */
    public function count(string $type = 'all', array $options = []): int
    {
        $this->insertUserDetailsJoin($options);
        return parent::count($type, $options);
    }

    /**
     * @param array $options
     */
    protected function insertUserDetailsJoin(array &$options)
    {
        $options['joins'] = $options['joins'] ?? [];
        // append a join condition to the options
        // for user details every time we fetch users
        $options['joins'] += [
            'UserDetails' => [
                'on' => 'UserDetails.userId = User.id',
                'table' => $this->userDetailsTable,
                'type' => Select::JOIN_LEFT
            ]
        ];
    }

    /**
     * @param MapperEvent $e
     */
    public function onAfterLoad(MapperEvent $e)
    {
        parent::onAfterLoad($e);

        /** @var UserEntity $entity */
        $user = $e->getParam('entity');

        /** @var array $data */
        $data = $e->getParam('data');

        $detailsData = array_filter($data['UserDetails']);
        if (!empty($detailsData)) {
            //load user details into user entity
            $details = $this->userDetailsHydrator->hydrate(
                array_filter($data['UserDetails']),
                clone $this->userDetailsPrototype
            );
            $user->setDetails($details);
        } else {
            $user->setDetails(new UserDetailsEntity());
        }
    }

    /**
     * @param MapperEvent $e
     */
    public function onAfterSave(MapperEvent $e)
    {
        parent::onAfterSave($e);

        //we save user details too, as a dependent mapping
        /** @var UserEntity $entity */
        $entity = $e->getParam('entity');
        /** @var UserDetailsEntity $details */
        $details = $entity->getDetails();
        $detailsData = $this->userDetailsHydrator->extract($details);

        $detailsColumns = $this->getDetailsColumns();
        $detailsData = array_intersect_key($detailsData, array_flip($detailsColumns));

        if ($details->getUserId()) {
            unset($detailsData['userId']);
            // update details
            $query = $this->getSql()->update($this->userDetailsTable)
                ->set($detailsData)
                ->where(['userId' => (int) $details->getUserId()]);
        } else {
            $details->setUserId($entity->getId());
            $detailsData['userId'] = $entity->getId();
            // insert
            $query = $this->getSql()->insert($this->userDetailsTable)
                ->columns(array_keys($detailsData))
                ->values($detailsData);
        }

        $stmt = $this->getSql()->prepareStatementForSqlObject($query);
        $result = $stmt->execute();
        if (!$result->valid()) {
            throw new \RuntimeException('Could not save user details data');
        }
    }

    /**
     * @return array
     */
    public function getDetailsColumns(): array
    {
        if (!$this->detailsColumns) {
            /** @var ColumnObject[] $detailsColumns */
            $detailsColumns = $this->getMetadata()->getTable($this->userDetailsTable)->getColumns();
            $this->detailsColumns = [];
            foreach ($detailsColumns as $column) {
                $this->detailsColumns[] = $column->getName();
            }
        }

        return $this->detailsColumns;
    }
}
