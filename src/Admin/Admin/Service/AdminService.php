<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/4/2016
 * Time: 7:44 PM
 */

namespace Dot\Admin\Admin\Service;

use Dot\Admin\Admin\Entity\AdminEntity;
use Dot\Admin\Admin\Mapper\AdminMapperInterface;
use Zend\Db\ResultSet\HydratingResultSet;

/**
 * Class AdminService
 * @package Dot\Admin\Admin\Service
 */
class AdminService implements AdminServiceInterface
{
    /** @var  AdminMapperInterface */
    protected $mapper;

    public function __construct(AdminMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param array $filters
     * @return AdminEntity[]
     */
    public function getAdmins(array $filters = [])
    {
        /** @var HydratingResultSet $admins */
        $admins = $this->mapper->findAllUsers();
        return $admins->toArray();
    }

    /**
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAdminsPaginated(array $filters = [], $limit = 30, $offset = 0)
    {
        /** @var HydratingResultSet $admins */
        $admins = $this->mapper->findUsersPaginated($filters, $limit, $offset);
        $total = $admins['total'];
        /** @var HydratingResultSet $rows */
        $rows = $admins['rows'];
        return ['total' => (int) $total, 'rows' => $rows->toArray()];
    }
}