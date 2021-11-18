<?php

declare(strict_types=1);

namespace Frontend\App\Service;

use Dot\AnnotatedServices\Annotation\Inject;
use Laminas\Session\Config\SessionConfig;
use Laminas\Session\SessionManager;

/**
 * Class TranslateService
 * @package Frontend\App\Service
 */
class TranslateService implements TranslateServiceInterface
{
    protected SessionManager $defaultSessionManager;

    protected array $translatorConfig = [];

    /**
     * TranslateService constructor.
     * @param SessionManager $defaultSessionManager
     * @param array $translatorConfig
     *
     * @Inject({SessionManager::class, "config.translator"})
     */
    public function __construct(SessionManager $defaultSessionManager, array $translatorConfig = [])
    {
        $this->defaultSessionManager = $defaultSessionManager;
        $this->translatorConfig = $translatorConfig;
    }

    /**
     * @param string $languageKey
     */
    public function addTranslatorCookie(string $languageKey)
    {
        /** @var SessionConfig $config */
        $config = $this->defaultSessionManager->getConfig();

        if ($config->getUseCookies()) {
            setcookie(
                $this->translatorConfig['cookie']['name'],
                $languageKey,
                [
                    'expires' => time() + $this->translatorConfig['cookie']['lifetime'],
                    'path' => $config->getCookiePath(),
                    'domain' => $config->getCookieDomain(),
                    'samesite' => $this->translatorConfig['cookie']['samesite'],
                    'secure' => $this->translatorConfig['cookie']['secure'],
                    'httponly' => $this->translatorConfig['cookie']['httponly']
                ]
            );
        }
    }
}
