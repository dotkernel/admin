<?php

declare(strict_types=1);

namespace Frontend\App\Common;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;
use Throwable;

/**
 * Class UuidOrderedTimeGenerator
 * @package Frontend\App\Common
 */
final class UuidOrderedTimeGenerator
{
    private static ?UuidFactory $factory = null;

    /**
     * @return UuidInterface|null
     */
    public static function generateUuid(): ?UuidInterface
    {
        try {
            return self::getFactory()->uuid1();
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
        }

        return null;
    }

    /**
     * @return UuidFactory
     */
    private static function getFactory(): UuidFactory
    {
        if (!self::$factory) {
            self::$factory = clone Uuid::getFactory();

            $codec = new OrderedTimeCodec(
                self::$factory->getUuidBuilder()
            );

            self::$factory->setCodec($codec);
        }

        return self::$factory;
    }
}
