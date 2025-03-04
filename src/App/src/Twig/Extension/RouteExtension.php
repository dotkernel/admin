<?php

declare(strict_types=1);

namespace Admin\App\Twig\Extension;

use Dot\DependencyInjection\Attribute\Inject;
use Mezzio\Helper\UrlHelper;
use Mezzio\Router\RouteResult;
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

    public function getCurrentRoute(): ?RouteResult
    {
        return $this->urlHelper->getRouteResult();
    }

    public function isRoute(?string $routeName): bool
    {
        if (null === $routeName) {
            return false;
        }

        if (null === $this->getCurrentRoute()) {
            return false;
        }

        return $this->getCurrentRoute()->getMatchedRouteName() === $routeName;
    }
}
