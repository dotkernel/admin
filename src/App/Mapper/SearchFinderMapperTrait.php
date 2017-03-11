<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Admin\App\Mapper;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

/**
 * Class SearchFinderMapperTrait
 * @package Admin\App\Mapper
 */
trait SearchFinderMapperTrait
{
    /**
     * @param Select $select
     * @param array $options
     * @return Select
     */
    public function findSearch(Select $select, array $options)
    {
        if (isset($options['search']) && is_array($options['search'])) {
            $search = $options['search'];
            $select->where(function (Where $where) use ($search) {
                $where = $where->nest();
                foreach ($search as $column => $value) {
                    $where->like($column, $value)->or;
                }
                $where->unnest()->and;
            });
        }

        return $select;
    }
}
