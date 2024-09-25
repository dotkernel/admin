<?php

declare(strict_types=1);

namespace Admin\App\Twig\Extension;

use Dot\DependencyInjection\Attribute\Inject;
use Mezzio\Helper\UrlHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouteExtension extends AbstractExtension
{
    #[Inject(UrlHelper::class)]
    public function __construct(
        private readonly UrlHelper $urlHelper,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCurrentRoute', [$this, 'getCurrentRoute']),
        ];
    }

    public function getCurrentRoute(): ?string
    {
        return $this->urlHelper->getRequest()?->getUri()?->getPath();
    }
}
