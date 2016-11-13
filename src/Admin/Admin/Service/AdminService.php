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
use Dot\User\Result\UserOperationResult;
use Dot\User\Service\PasswordInterface;
use Zend\Db\ResultSet\HydratingResultSet;

/**
 * Class AdminService
 * @package Dot\Admin\Admin\Service
 */
class AdminService implements AdminServiceInterface
{
    /** @var  AdminMapperInterface */
    protected $mapper;

    /** @var  PasswordInterface */
    protected $passwordService;

    public function __construct(AdminMapperInterface $mapper, PasswordInterface $passwordService)
    {
        $this->mapper = $mapper;
        $this->passwordService = $passwordService;
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
        return ['total' => (int)$total, 'rows' => $rows->toArray()];
    }

    /**
     * @param AdminEntity $admin
     * @return UserOperationResult
     */
    public function saveAdmin(AdminEntity $admin)
    {
        $operation = 'create';
        try {
            if ($admin->getId()) {
                $operation = 'update';

                //var_dump($admin);exit;
                if(!empty($admin->getPassword())) {
                    $admin->setPassword($this->hashPassword($admin->getPassword()));
                }
                //remove date created from update
                $admin->setDateCreated(null);

                $this->mapper->updateUser($admin);

                return new UserOperationResult(true, 'Admin successfully updated');
            } else {
                $operation = 'create';

                $admin->setPassword($this->hashPassword($admin->getPassword()));
                $this->mapper->createUser($admin);

                return new UserOperationResult(true, 'Admin account successfully created');
            }
        } catch (\Exception $e) {
            error_log('Admin account creation/update error: ' . $e->getMessage());
            return  new UserOperationResult(false, 'Admin ' . $operation === 'update' ? 'update' : 'create'
                . ' unexpected server error. Please try again');
        }
    }


    public function deleteAdminsById($id, $markAsDeleted = true)
    {
        if(!is_array($id)) {
            $id = [$id];
        }
        $ids = [];
        foreach ($id as $i) {
            if(is_numeric($i)) {
                $ids[] = (int) $i;
            }
        }

        if(empty($ids)) {
            return new UserOperationResult(true, 'There were no valid accounts selected for removal. Nothing was done');
        }

        try {
            $this->mapper->deleteAdminsById($ids, $markAsDeleted);
            return new UserOperationResult(true, 'Admin accounts successfully removed');
        } catch (\Exception $e) {
            error_log('Error deleting admin account: ' . $e->getMessage());
            return new UserOperationResult(false, 'Could not remove selected accounts due to a server error. Please try again');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAdminById($id)
    {
        return $this->mapper->findUser($id);
    }

    /**
     * @param $clearPassword
     * @return mixed
     */
    protected function hashPassword($clearPassword)
    {
        if($clearPassword) {
            return $this->passwordService->create($clearPassword);
        }

        return $clearPassword;
    }
}