<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-user
 * @author: n3vrax
 * Date: 6/23/2016
 * Time: 9:01 PM
 */

namespace Dot\Admin\Validator;

use Dot\Ems\Service\EntityService;
use Zend\Validator\AbstractValidator;

/**
 * Class AbstractRecord
 * @package Dot\User\Validator
 */
abstract class AbstractRecord extends AbstractValidator
{
    /**
     * Error constants
     */
    const ERROR_NO_RECORD_FOUND = 'noRecordFound';
    const ERROR_RECORD_FOUND = 'recordFound';
    /**
     * @var array Message templates
     */
    protected $messageTemplates = array(
        self::ERROR_NO_RECORD_FOUND => "No record matching the input was found",
        self::ERROR_RECORD_FOUND => "A record matching the input was found",
    );
    /**
     * @var EntityService
     */
    protected $service;

    /**
     * @var string
     */
    protected $key;

    /**
     * Required options are:
     *  - key
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (!array_key_exists('key', $options)) {
            throw new \InvalidArgumentException('No key provided');
        }
        $this->setKey($options['key']);
        parent::__construct($options);
    }

    /**
     * getService
     *
     * @return EntityService
     */
    public function getService()
    {
        return $this->mapper;
    }

    /**
     * setService
     *
     * @param EntityService $service
     * @return AbstractRecord
     */
    public function setService(EntityService $service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * Get key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set key.
     *
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Grab the user from the mapper
     *
     * @param string $value
     * @return mixed
     */
    protected function query($value)
    {
        $result = $this->service->find([$this->getKey() => $value]);
        return $result;
    }
}