<?php
/**
 * @see https://github.com/dotkernel/admin/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/admin/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Admin\Console\Command;

use Dot\AnnotatedServices\Annotation\Service;
use Dot\Console\Command\AbstractCommand;
use Zend\Console\Adapter\AdapterInterface;
use ZF\Console\Route;

/**
 * Class HelloCommand
 * @package Admin\Console\Command
 *
 * @Service
 */
class HelloCommand extends AbstractCommand
{
    /**
     * @param Route $route
     * @param AdapterInterface $console
     * @return int
     */
    public function __invoke(Route $route, AdapterInterface $console)
    {
        $console->writeLine(
            <<<EOT
  _   _      _ _              ____        _   _  __                    _    _ 
 | | | | ___| | | ___        |  _ \  ___ | |_| |/ /___ _ __ _ __   ___| |  | |
 | |_| |/ _ \ | |/ _ \       | | | |/ _ \| __| ' // _ \ '__| '_ \ / _ \ |  | |
 |  _  |  __/ | | (_) |  _   | |_| | (_) | |_| . \  __/ |  | | | |  __/ |  |_|
 |_| |_|\___|_|_|\___/  ( )  |____/ \___/ \__|_|\_\___|_|  |_| |_|\___|_|  (_)
                        |/

EOT
        );
        return 0;
    }
}
