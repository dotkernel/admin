<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/3/2017
 * Time: 2:51 AM
 */

declare(strict_types = 1);

namespace Admin\App\Form\Element;

use Admin\App\Exception\RuntimeException;
use Dot\Ems\Entity\EntityInterface;
use Dot\Ems\Mapper\MapperInterface;
use Dot\Ems\Mapper\MapperManager;
use Zend\Form\Element\Select;

/**
 * Class EntitySelect
 * @package Admin\App\Form\Element
 */
class EntitySelect extends Select
{
    /** @var  MapperManager */
    protected $mapperManager;

    /** @var  MapperInterface */
    protected $mapper;

    /** @var  array */
    protected $entities;

    /** @var  string */
    protected $targetEntity;

    /** @var  string */
    protected $property;

    /** @var string  */
    protected $findMethod = 'all';

    /** @var array  */
    protected $findOptions = [];

    /** @var  callable */
    protected $labelGenerator;

    /** @var  string|null */
    protected $optgroupIdentifier;

    /** @var  string|null */
    protected $entityIdentifier;

    /**
     * @param array|\Traversable $options
     * @return $this
     */
    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($options['mapper_manager'])) {
            $this->setMapperManager($options['mapper_manager']);
        }

        if (isset($options['target_entity'])) {
            $this->setTargetEntity($options['target_entity']);
        }

        if (isset($options['find_method'])) {
            $this->setFindMethod($options['find_method']);
        }

        if (isset($options['find_options'])) {
            $this->setFindOptions($options['find_options']);
        }

        if (isset($options['property'])) {
            $this->setProperty($options['property']);
        }

        if (isset($options['entity_identifier'])) {
            $this->setEntityIdentifier($options['entity_identifier']);
        }

        if (isset($options['optgroup_identifier'])) {
            $this->setOptgroupIdentifier($options['optgroup_identifier']);
        }

        if (isset($options['label_generator']) && is_callable($options['label_generator'])) {
            $this->setLabelGenerator($options['label_generator']);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setOption($key, $value)
    {
        parent::setOption($key, $value);
        $this->setOptions([$key => $value]);

        return $this;
    }

    /**
     * @return array
     */
    public function getValueOptions()
    {
        if (!empty($this->valueOptions)) {
            return $this->valueOptions;
        }

        $valueOptions = $this->loadValueOptions();

        if (!empty($valueOptions)) {
            $this->setValueOptions($valueOptions);
        }

        return $this->valueOptions;
    }

    /**
     * @return array
     */
    public function getEntities()
    {
        $this->loadEntities();
        return $this->entities;
    }

    protected function loadEntities()
    {
        if (!empty($this->entities)) {
            return;
        }

        $finder = $this->getFindMethod();
        $findOptions = $this->getFindOptions();

        /** @var MapperInterface $mapper */
        $mapper = $this->mapperManager->get($this->getTargetEntity());
        $entities = $mapper->find($finder, $findOptions);

        $this->entities = $entities;
    }

    protected function loadValueOptions()
    {
        if (!$this->mapperManager) {
            throw new RuntimeException('No mapper manager was set');
        }

        if (!$this->targetEntity) {
            throw new RuntimeException('No target entity was set');
        }

        $identifier = $this->getEntityIdentifier();
        $entities = $this->getEntities();
        $options = [];
        $optionsAttributes = [];

        if ($this->getEmptyOption()) {
            $options[''] = $this->getEmptyOption();
        }

        /**
         * @var  $key
         * @var  EntityInterface $entity
         */
        foreach ($entities as $key => $entity) {
            if (null !== ($generatedLabel = $this->generateLabel($entity))) {
                $label = $generatedLabel;
            } elseif ($property = $this->getProperty()) {
                if (!$entity->hasProperties([$property])) {
                    throw new RuntimeException(sprintf(
                        'Property `%s` could not be found in object `%s`',
                        $property,
                        $this->getTargetEntity()
                    ));
                }

                $label = $entity->extractProperties([$property])[$property];
            } else {
                $label = (string) $entity;
            }

            if (!$identifier) {
                $value = $key;
            } else {
                $value = $identifier;
            }
        }

    }

    /**
     * @param $entity
     * @return null|string
     */
    protected function generateLabel(EntityInterface $entity): ?string
    {
        $generator = $this->getLabelGenerator();
        if (!$generator) {
            return null;
        }

        if (!is_callable($generator)) {
            return null;
        }

        return $generator($entity);
    }

    /**
     * @return MapperManager
     */
    public function getMapperManager(): MapperManager
    {
        return $this->mapperManager;
    }

    /**
     * @param MapperManager $mapperManager
     */
    public function setMapperManager(MapperManager $mapperManager)
    {
        $this->mapperManager = $mapperManager;
    }

    /**
     * @return string
     */
    public function getTargetEntity(): string
    {
        return $this->targetEntity;
    }

    /**
     * @param string $targetEntity
     */
    public function setTargetEntity(string $targetEntity)
    {
        $this->targetEntity = $targetEntity;
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param string $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * @return string
     */
    public function getFindMethod(): string
    {
        return $this->findMethod;
    }

    /**
     * @param string $findMethod
     */
    public function setFindMethod(string $findMethod)
    {
        $this->findMethod = $findMethod;
    }

    /**
     * @return array
     */
    public function getFindOptions(): array
    {
        return $this->findOptions;
    }

    /**
     * @param array $findOptions
     */
    public function setFindOptions(array $findOptions)
    {
        $this->findOptions = $findOptions;
    }

    /**
     * @return callable
     */
    public function getLabelGenerator()
    {
        return $this->labelGenerator;
    }

    /**
     * @param callable $labelGenerator
     */
    public function setLabelGenerator($labelGenerator)
    {
        $this->labelGenerator = $labelGenerator;
    }

    /**
     * @return null|string
     */
    public function getOptgroupIdentifier()
    {
        return $this->optgroupIdentifier;
    }

    /**
     * @param null|string $optgroupIdentifier
     */
    public function setOptgroupIdentifier($optgroupIdentifier)
    {
        $this->optgroupIdentifier = $optgroupIdentifier;
    }

    /**
     * @return null|string
     */
    public function getEntityIdentifier()
    {
        return $this->entityIdentifier;
    }

    /**
     * @param null|string $entityIdentifier
     */
    public function setEntityIdentifier($entityIdentifier)
    {
        $this->entityIdentifier = $entityIdentifier;
    }
}
