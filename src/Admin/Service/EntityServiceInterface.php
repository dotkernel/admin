<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 9:16 PM
 */

namespace Dot\Admin\Service;

use Dot\Ems\Service\ServiceInterface;


/**
 * Interface EntityServiceInterface
 * @package Dot\Authentication\Service
 */
interface EntityServiceInterface extends ServiceInterface
{
    /**
     * @param $ids
     * @return mixed
     */
    public function markAsDeleted($ids);

    /**
     * @param array $ids
     * @return mixed
     */
    public function bulkDelete($ids);
}