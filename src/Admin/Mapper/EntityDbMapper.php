<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 9:31 PM
 */

namespace Dot\Admin\Mapper;

use Dot\Ems\Mapper\AbstractDbMapper;
use Zend\Db\Sql\Where;

/**
 * Class DbMapper
 * @package Dot\Admin\Mapper
 */
class EntityDbMapper extends AbstractDbMapper  implements EntityMapperExtensionInterface
{
    /**
     * @param $fieldName
     * @param string $deletedValue
     * @param $ids
     * @return int
     */
    public function markAsDeleted(array $ids, $fieldName, $deletedValue = 'deleted')
    {
        $sql = $this->tableGateway->getSql();
        $update = $sql->update()->set([$fieldName => $deletedValue])->where(function(Where $where) use ($ids){
            $where->in('id', $ids);
        });
        return $this->tableGateway->updateWith($update);
    }

    /**
     * @param $ids
     * @return int
     */
    public function bulkDelete(array $ids)
    {
        $sql = $this->tableGateway->getSql();
        $delete = $sql->delete()->where(function(Where $where) use ($ids) {
            $where->in('id', $ids);
        });
        return $this->tableGateway->deleteWith($delete);
    }
}