<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-admin
 * @author: n3vrax
 * Date: 11/23/2016
 * Time: 10:33 PM
 */

namespace Dot\Admin\Authentication;

use Zend\Crypt\Password\PasswordInterface;

/**
 * Class PasswordCheck
 * @package Dot\Admin\Authentication
 */
class PasswordCheck
{
    /** @var  PasswordInterface */
    protected $passwordService;

    /**
     * PasswordCheck constructor.
     * @param PasswordInterface $passwordService
     */
    public function __construct(PasswordInterface $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    /**
     * @param $hash
     * @param $password
     * @return bool
     */
    public function __invoke($hash, $password)
    {
        return $this->passwordService->verify($password, $hash);
    }
}