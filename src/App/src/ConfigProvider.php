<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Admin\App;

use Admin\App\Form\ConfirmDeleteForm;
use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 * @package Admin\App
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),

            'dot_form' => $this->getForms(),

            'templates' => $this->getTemplates(),
        ];
    }

    public function getDependencies(): array
    {
        return [

        ];
    }

    public function getForms(): array
    {
        return [
            'form_manager' => [
                'factories' => [
                    ConfirmDeleteForm::class => InvokableFactory::class,
                ],
                'aliases' => [
                    'ConfirmDelete' => ConfirmDeleteForm::class,
                ]
            ]
        ];
    }

    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app' => [__DIR__ . '/../templates/app'],
                'error' => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
                'partial' => [__DIR__ . '/../templates/partial']
            ]
        ];
    }
}
