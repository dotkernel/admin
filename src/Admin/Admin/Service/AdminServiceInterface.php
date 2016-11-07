<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/6/2016
 * Time: 9:37 PM
 */

namespace Dot\Admin\Admin\Service;
use Dot\Admin\Admin\Entity\AdminEntity;

/**
 * Interface AdminServiceInterface
 * @package Dot\Admin\Admin\Service
 */
interface AdminServiceInterface
{
    /**
     * Get list of all admins
     * @return AdminEntity[]|null
     */
    public function getAdmins();
}