<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/7/2016
 * Time: 10:58 PM
 */

namespace Dot\Admin\Admin\Mapper;

use Dot\User\Mapper\UserDbMapper;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

/**
 * Class AdminDbMapper
 * @package Dot\Admin\Admin\Mapper
 */
class AdminDbMapper extends UserDbMapper implements AdminMapperInterface
{
    /** @var array  */
    protected $sortableColumns = [
        'id' => 'INT', 'email' => 'CHAR', 'username' => 'CHAR', 'firstName' => 'CHAR', 'lastName' => 'CHAR',
        'role' => 'ENUM', 'status' => 'ENUM', 'dateCreated' => 'DATE'
    ];

    /**
     * @param array $filters
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function findAllUsers(array $filters = [])
    {
        $select = $this->getSql()->select();
        $select = $this->applyFilters($select, $filters);
        return $this->selectWith($select);
    }

    /**
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findUsersPaginated(array $filters = [], $limit = 30, $offset = 0)
    {
        $select = $this->getSql()->select()->limit($limit)->offset($offset);

        $select = $this->applyFilters($select, $filters);
        //var_dump($select->getSqlString($this->adapter->getPlatform()));exit;
        $countSelect = clone $select;
        $countSelect->columns(array('num' => new Expression('COUNT(*)')));
        //select count rows for this particular query
        $stmt = $this->getSql()->prepareStatementForSqlObject($countSelect);
        $count = $stmt->execute();

        $results = $this->selectWith($select);
        return ['total' => (int) $count->current()['num'], 'rows' => $results];
    }

    /**
     * @param Select $select
     * @param array $filters
     * @return Select
     */
    protected function applyFilters(Select $select, array $filters = [])
    {
        if(empty($filters)) {
            return $select;
        }

        //apply search by keyword filter
        $search = isset($filters['search']) ? $filters['search'] : '';
        if(!empty($search)) {
            $select->where(function(Where $where) use ($search) {
                $predicate = $where->nest();
                foreach ($this->sortableColumns as $key => $value) {
                    if(in_array($value, ['CHAR', 'VARCHAR'])) {
                        $predicate->like($key, '%' . $search . '%')->or;
                    }
                }
                $predicate->unnest();
                $where->predicate($predicate);
            });
        }

        //sorting options
        $sort = isset($filters['sort']) ? $filters['sort'] : '';
        $order = isset($filters['order']) ? $filters['order'] : 'asc';

        //make sure order param is just the allowed ones
        if(!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

        //sort only if we have a value and it is a valid field
        if(!empty($sort) && in_array($sort, array_keys($this->sortableColumns))) {
            if(in_array($this->sortableColumns[$sort], ['ENUM'])) {
                $select->order(new Expression('CAST(' . $this->getAdapter()->getPlatform()->quoteIdentifier($sort)
                    . ' as CHAR) ' . $order));
            }
            else {
                $select->order([$sort => $order]);
            }
        }

        return $select;

    }
}