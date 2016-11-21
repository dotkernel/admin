<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-user
 * @author: n3vrax
 * Date: 6/23/2016
 * Time: 9:10 PM
 */

namespace Dot\Admin\Validator;

/**
 * Class RecordExists
 * @package Dot\User\Validator
 */
class RecordExists extends AbstractRecord
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function isValid($value)
    {
        $valid = true;
        $this->setValue($value);
        $result = $this->query($value);
        if (!$result) {
            $valid = false;
            $this->error(self::ERROR_NO_RECORD_FOUND);
        }
        return $valid;
    }
}