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
            new TwigFunction('isRoute', [$this, 'isRoute']),
        ];
    }

    public function getCurrentRoute(): ?string
    {
        return $this->urlHelper->getRequest()?->getUri()?->getPath();
    }

    public function isRoute(?string $route): bool
    {
        if (null === $route) {
            return false;
        }

        $currentRoute = $this->getCurrentRoute();
        if (null === $currentRoute) {
            return false;
        }

        return $currentRoute === $route;
    }
}
