<?php

declare(strict_types=1);

namespace Frontend\App\Service;

/**
 * Class TranslateServiceInterface
 * @package Frontend\App\Service
 */
interface TranslateServiceInterface
{
    /**
     * @param string $languageKey
     */
    public function addTranslatorCookie(string $languageKey);
}
