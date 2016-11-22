<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/21/2016
 * Time: 10:09 PM
 */

namespace Dot\Admin\Service;

use Dot\Admin\Mapper\EntityMapperExtensionInterface;
use Dot\Ems\Service\EntityService;

/**
 * Class AbstractEntityService
 * @package Dot\Admin\Service
 */
abstract class AbstractEntityService extends EntityService implements EntityServiceExtensionInterface
{
    /** @var  EntityMapperExtensionInterface */
    protected $entityExtensionMapper;

    /**
     * @return EntityMapperExtensionInterface
     */
    public function getEntityExtensionMapper()
    {
        return $this->entityExtensionMapper;
    }

    /**
     * @param EntityMapperExtensionInterface $entityExtensionMapper
     * @return $this
     */
    public function setEntityExtensionMapper(EntityMapperExtensionInterface $entityExtensionMapper)
    {
        $this->entityExtensionMapper = $entityExtensionMapper;
        return $this;
    }


}