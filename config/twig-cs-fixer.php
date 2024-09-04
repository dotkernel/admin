<?php

declare(strict_types=1);

$config = new TwigCsFixer\Config\Config();
$config->addTwigExtension(new Dot\Twig\Extension\DateExtension());
$config->addTwigExtension(new Dot\Twig\Extension\TranslationExtension());

return $config;
