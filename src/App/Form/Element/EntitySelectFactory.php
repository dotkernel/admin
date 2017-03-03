<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/3/2017
 * Time: 8:45 PM
 */

declare(strict_types = 1);

namespace Admin\App\Form\Element;

use Dot\Ems\Mapper\MapperManager;
use Interop\Container\ContainerInterface;
use Zend\Form\ElementFactory;

/**
 * Class EntitySelectFactory
 * @package Admin\App\Form\Element
 */
class EntitySelectFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options = $options ?? [];
        $elementFactory = new ElementFactory();
        $options['mapper_manager'] = $container->get(MapperManager::class);

        return $elementFactory->__invoke($container, $requestedName, $options);
    }
}
