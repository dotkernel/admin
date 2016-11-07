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
use Dot\User\Mapper\UserMapperInterface;

/**
 * Class AdminService
 * @package Dot\Admin\Admin\Service
 */
class AdminService implements AdminServiceInterface
{
    /** @var  UserMapperInterface */
    protected $mapper;

    public function __construct(UserMapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getAdmins()
    {
        /** @var AdminEntity[] $admins */
        $admins = $this->mapper->findAllUsers();
        return $admins;
    }
}