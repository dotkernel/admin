<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Admin\User\Hydrator;

use Dot\Hydrator\ClassMethodsCamelCase;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class AdminHydrator
 * @package Admin\User\Entity
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
