<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/11/2016
 * Time: 2:37 AM
 */

namespace Dot\Admin\Admin\Entity;


class AdminCollectionEntity
{
    /** @var  AdminEntity[] */
    protected $admins;

    /**
     * @return AdminEntity[]
     */
    public function getAdmins()
    {
        return $this->admins;
    }

    /**
     * @param AdminEntity[] $admins
     * @return AdminCollectionEntity
     */
    public function setAdmins($admins)
    {
        $this->admins = $admins;
        return $this;
    }

}