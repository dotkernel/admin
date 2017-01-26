<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 1/26/2017
 * Time: 3:06 AM
 */

namespace Dot\Admin\Mapper;

use Dot\Ems\Mapper\RelationalDbMapper;
use Zend\Db\Sql\Where;

/**
 * Class EntityDbMapper
 * Extends the RelationalDbMapper, as this acts as a normal DbMapper when no relations are provided
 * Adds bulk delete queries
 * @package Dot\Admin\Mapper
 */
class EntityDbMapper extends RelationalDbMapper
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
        $update = $sql->update()->set([$fieldName => $deletedValue])->where(function (Where $where) use ($ids) {
            $where->in('id', $ids);
        });
        $stmt = $sql->prepareStatementForSqlObject($update);
        return $stmt->execute()->getAffectedRows();
    }

    /**
     * @param $ids
     * @return int
     */
    public function bulkDelete(array $ids)
    {
        $sql = $this->tableGateway->getSql();
        $delete = $sql->delete()->where(function (Where $where) use ($ids) {
            $where->in('id', $ids);
        });
        $stmt = $sql->prepareStatementForSqlObject($delete);
        return $stmt->execute()->getAffectedRows();
    }
}
