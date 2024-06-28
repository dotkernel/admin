<?php

declare(strict_types=1);

namespace Frontend\App\Exception;

use Exception;

class ORMException extends Exception implements \Doctrine\ORM\Exception\ORMException
{
}
