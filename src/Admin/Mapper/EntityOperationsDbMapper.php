<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 9:31 PM
 */

namespace Dot\Admin\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

/**
 * Class DbMapper
 * @package Dot\Authentication\Mapper
 */
class EntityOperationsDbMapper implements EntityOperationsMapperInterface
{
    /** @var  Adapter */
    protected $adapter;

    /** @var  string */
    protected $table;

    /** @var  Sql */
    protected $sql;

    /**
     * EntityOperationsDbMapper constructor.
     * @param $table
     * @param Adapter $adapter
     */
    public function __construct($table, Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->table = $table;
        $this->sql = new Sql($this->adapter, $table);
    }

    /**
     * @param $fieldName
     * @param string $deletedValue
     * @param $ids
     * @return int
     */
    public function markAsDeleted(array $ids, $fieldName, $deletedValue = 'deleted')
    {
        $update = $this->sql->update()->set([$fieldName => $deletedValue])->where(function (Where $where) use ($ids) {
            $where->in('id', $ids);
        });
        $stmt = $this->sql->prepareStatementForSqlObject($update);
        return $stmt->execute()->getAffectedRows();
    }

    /**
     * @param $ids
     * @return int
     */
    public function bulkDelete(array $ids)
    {
        $delete = $this->sql->delete()->where(function (Where $where) use ($ids) {
            $where->in('id', $ids);
        });
        $stmt = $this->sql->prepareStatementForSqlObject($delete);
        return $stmt->execute()->getAffectedRows();
    }
}
