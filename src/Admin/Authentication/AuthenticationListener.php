<?php
/**
 * @see https://github.com/dotkernel/dot-admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Admin\Admin\Authentication;

use Dot\Authentication\Adapter\Db\DbCredentials;
use Dot\Authentication\Web\Event\AbstractAuthenticationEventListener;
use Dot\Authentication\Web\Event\AuthenticationEvent;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuthenticationListener
 * @package App\Admin\Authentication
 */
class AuthenticationListener extends AbstractAuthenticationEventListener
{
    /**
     * @param AuthenticationEvent $e
     */
    public function onBeforeAuthentication(AuthenticationEvent $e)
    {
        /** @var ServerRequestInterface $request */
        $request = $e->getParam('request');
        $error = $e->getParam('error');

        if (empty($error)) {
            /** @var array $data */
            $data = $e->getParam('data');
            $identity = $data['identity'] ?? '';
            $credential = $data['password'] ?? '';

            if (empty($identity) || empty($credential)) {
                $e->setParam('error', 'Credentials are required and cannot be empty');
                return;
            }

            $dbCredentials = new DbCredentials($identity, $credential);
            $e->setParam('request', $request->withAttribute(DbCredentials::class, $dbCredentials));
        }
    }
}
