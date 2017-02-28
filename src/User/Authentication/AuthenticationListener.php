<?php
/**
 * @copyright: DotKernel
 * @library: dot-frontend
 * @author: n3vrax
 * Date: 2/23/2017
 * Time: 4:40 PM
 */

declare(strict_types = 1);

namespace Admin\User\Authentication;

use Dot\Authentication\Adapter\Db\DbCredentials;
use Dot\Authentication\Web\Event\AbstractAuthenticationEventListener;
use Dot\Authentication\Web\Event\AuthenticationEvent;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuthenticationListener
 * @package App\User\Authentication
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
