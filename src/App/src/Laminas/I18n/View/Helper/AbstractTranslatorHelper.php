<?php

declare(strict_types=1);

namespace Admin\App\Laminas\I18n\View\Helper;

use Laminas\View\Helper\AbstractHelper;

abstract class AbstractTranslatorHelper extends AbstractHelper
{
    public function getTranslator(): null
    {
        return null;
    }
}
