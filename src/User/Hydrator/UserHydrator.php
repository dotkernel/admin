<?php
/**
 * @copyright: DotKernel
 * @library: dot-admin
 * @author: n3vrax
 * Date: 3/4/2017
 * Time: 11:56 PM
 */

declare(strict_types = 1);

namespace Admin\User\Hydrator;

use Dot\Hydrator\ClassMethodsCamelCase;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class AdminHydrator
 * @package Admin\Admin\Entity
 */
class UserHydrator extends ClassMethodsCamelCase
{
    /** @var  StrategyInterface */
    protected $rolesStrategy;

    /**
     * AdminHydrator constructor.
     * @param StrategyInterface $rolesStrategy
     */
    public function __construct(StrategyInterface $rolesStrategy)
    {
        parent::__construct();
        $this->rolesStrategy = $rolesStrategy;

        $this->addStrategy('roles', $rolesStrategy);
    }
}
