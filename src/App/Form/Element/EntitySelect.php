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
use Zend\Stdlib\ArrayUtils;

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
    protected $target;

    /** @var  string */
    protected $property;

    /** @var string  */
    protected $finder = 'all';

    /** @var array  */
    protected $findOptions = [];

    /** @var  callable */
    protected $labelGenerator;

    /** @var  string|null */
    protected $optgroupIdentifier;

    /** @var  string|null */
    protected $optgroupDefault;

    /** @var  array */
    protected $optionAttributes = [];

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

        if (isset($options['target'])) {
            $this->setTarget($options['target']);
        }

        if (isset($options['finder'])) {
            $this->setFinder($options['finder']);
        }

        if (isset($options['find_options'])) {
            $this->setFindOptions($options['find_options']);
        }

        if (isset($options['property'])) {
            $this->setProperty($options['property']);
        }

        if (isset($options['optgroup_identifier'])) {
            $this->setOptgroupIdentifier($options['optgroup_identifier']);
        }

        if (isset($options['label_generator']) && is_callable($options['label_generator'])) {
            $this->setLabelGenerator($options['label_generator']);
        }

        if (isset($options['option_attributes'])) {
            $this->setOptionAttributes($options['option_attributes']);
        }

        if (isset($options['optgroup_default'])) {
            $this->setOptgroupDefault($options['optgroup_default']);
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

    public function setValue($value)
    {
        if ($this->isMultiple()) {
            if ($value instanceof \Traversable) {
                $value = ArrayUtils::iteratorToArray($value);
            } elseif ($value == null) {
                return parent::setValue([]);
            } elseif (!is_array($value)) {
                $value = (array) $value;
            }

            return parent::setValue(array_map([$this, 'getEntityValue'], $value));
        }

        return parent::setValue($this->getEntityValue($value));
    }

    public function getEntityValue($value)
    {
        if ($value instanceof EntityInterface) {
            $identifier = $this->getMapper()->getPrimaryKey();

            if (count($identifier) !== 1) {
                //$value = $key;
            } else {
                $identifier = current($identifier);
                $value = $value->extractProperty($identifier);
            }
        }

        return $value;
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

        $finder = $this->getFinder();
        $findOptions = $this->getFindOptions();

        $entities = $this->getMapper()->find($finder, $findOptions);
        $this->entities = $entities;
    }

    protected function loadValueOptions()
    {
        if (!$this->mapperManager) {
            throw new RuntimeException('No mapper manager was set');
        }

        if (!$this->target) {
            throw new RuntimeException('No target entity was set');
        }

        $identifier = $this->getMapper()->getPrimaryKey();
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
                if (!$entity->hasProperty($property)) {
                    throw new RuntimeException(sprintf(
                        'Property `%s` could not be found in object `%s`',
                        $property,
                        $this->getTarget()
                    ));
                }

                $label = $entity->extractProperty($property);
            } else {
                $label = (string) $entity;
            }

            if (count($identifier) !== 1) {
                $value = $key;
            } else {
                if (!$entity->hasProperty(current($identifier))) {
                    throw new RuntimeException(sprintf(
                        'Entity does not have identifier property `%s`',
                        current($identifier)
                    ));
                }
                $value = $entity->extractProperty(current($identifier));
            }

            foreach ($this->getOptionAttributes() as $optionKey => $optionValue) {
                if (is_string($optionValue)) {
                    $optionsAttributes[$optionKey] = $optionValue;
                    continue;
                }

                if (is_callable($optionValue)) {
                    $callableValue = call_user_func($optionValue, $entity);
                    $optionsAttributes[$optionKey] = (string) $callableValue;
                    continue;
                }
            }

            if (is_null($this->getOptgroupIdentifier())) {
                $options[] = ['label' => $label, 'value' => $value, 'attributes' => $optionsAttributes];
                continue;
            }

            if (!$entity->hasProperty($this->getOptgroupIdentifier())) {
                throw new RuntimeException(sprintf(
                    'Entity object does not have a property `%s` defined',
                    $this->getOptgroupIdentifier()
                ));
            }

            $optGroup = $entity->extractProperty($this->getOptgroupIdentifier());

            if (false === is_null($optGroup) && trim($optGroup) !== '') {
                $options[$optGroup]['label'] = $optGroup;
                $options[$optGroup]['options'][] = [
                    'label' => $label,
                    'value' => $value,
                    'attributes' => $optionsAttributes,
                ];

                continue;
            }

            $optGroupDefault = $this->getOptgroupDefault();
            if (is_null($optGroupDefault)) {
                $options[] = ['label' => $label, 'value' => $value, 'attributes' => $optionsAttributes];
                continue;
            }

            $options[$optGroupDefault]['label'] = $optGroupDefault;
            $options[$optGroupDefault]['options'][] = [
                'label' => $label,
                'value' => $value,
                'attributes' => $optionsAttributes,
            ];
        }

        $this->valueOptions = $options;
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
     * @return MapperInterface
     */
    public function getMapper(): MapperInterface
    {
        if (!$this->mapper) {
            $this->mapper = $this->mapperManager->get($this->getTarget());
        }

        return $this->mapper;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target)
    {
        $this->target = $target;
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
    public function getFinder(): string
    {
        return $this->finder;
    }

    /**
     * @param string $finder
     */
    public function setFinder(string $finder)
    {
        $this->finder = $finder;
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
     * @return array
     */
    public function getOptionAttributes(): array
    {
        return $this->optionAttributes;
    }

    /**
     * @param array $optionAttributes
     */
    public function setOptionAttributes(array $optionAttributes)
    {
        $this->optionAttributes = $optionAttributes;
    }

    /**
     * @return null|string
     */
    public function getOptgroupDefault()
    {
        return $this->optgroupDefault;
    }

    /**
     * @param null|string $optgroupDefault
     */
    public function setOptgroupDefault($optgroupDefault)
    {
        $this->optgroupDefault = $optgroupDefault;
    }
}
