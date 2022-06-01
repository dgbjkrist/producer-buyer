<?php

declare(strict_types=1);

namespace App\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Symfony\Component\Uid\Uuid;
use Doctrine\DBAL\Types\GuidType;

class UuidType extends GuidType
{
    public const NAME = "uuid";

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof Uuid) {
            return $value;
        }

        try {
            $uuid = Uuid::fromString($value);
        } catch (\Throwable $th) {
            throw new ConversionException($value, self::NAME);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (
            $value instanceof Uuid || (
            (is_string($value) || method_exists($value, '__toString')) && Uuid::isValid($value)
            )
        ) {
            return $value;
        }

        throw ConversionException::conversionFailed($value, $this->getName());
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
