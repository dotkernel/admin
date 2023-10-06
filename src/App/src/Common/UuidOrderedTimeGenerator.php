<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactoryInterface;
use Ramsey\Uuid\UuidInterface;

final class UuidOrderedTimeGenerator
{
    private static UuidFactoryInterface $factory;

    public static function generateUuid(): UuidInterface
    {
        return self::getFactory()->uuid1();
    }

    private static function getFactory(): UuidFactoryInterface
    {
        self::$factory = clone Uuid::getFactory();
        $codec         = new OrderedTimeCodec(self::$factory->getUuidBuilder());
        self::$factory->setCodec($codec);

        return self::$factory;
    }
}
