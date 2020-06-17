<?php

/**
 * @see https://github.com/dotkernel/dot-controller/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-controller/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Frontend\Plugin;

use Mezzio\Template\TemplateRendererInterface;

/**
 * Class TemplatePlugin
 * @package Frontend\Plugin
 */
class TemplatePlugin implements PluginInterface
{
    /** @var TemplateRendererInterface */
    protected $template;

    /**
     * TemplatePlugin constructor.
     * @param TemplateRendererInterface $template
     */
    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    /**
     * @param string|null $templateName
     * @param array|null $params
     * @return mixed
     */
    public function __invoke(string $templateName = null, array $params = [])
    {
        $args = func_get_args();
        if (empty($args)) {
            return $this;
        }

        return $this->render($templateName, $params);
    }

    /**
     * @param string $templateName
     * @param array $params
     * @return string
     */
    public function render(string $templateName, array $params = []): string
    {
        return $this->template->render($templateName, $params);
    }

    /**
     * @param string $templateName
     * @param string $param
     * @param mixed $value
     */
    public function addDefaultParam(string $templateName, string $param, $value)
    {
        $this->template->addDefaultParam($templateName, $param, $value);
    }
}
