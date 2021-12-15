<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 15/12/2021
 */

declare(strict_types=1);

namespace JeckelLab\ValueObject;

use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\Contract\Domain\ValueObject\ValueObject;

/**
 * Class AbstractValueObject
 * @package JeckelLab\ValueObject
 * @psalm-immutable
 * @template ValueType of scalar
 */
abstract class AbstractScalarValueObject implements ValueObject
{
    /**
     * @var ValueType
     */
    protected bool|int|float|string $value;

    /**
     * @var array<class-string<AbstractScalarValueObject<scalar>>, array<string|int, AbstractScalarValueObject<scalar>>>
     */
    private static array $instances = [];

    /**
     * @param ValueType $value
     */
    private function __construct(bool|int|float|string $value)
    {
        $this->value = $value;
    }

    /**
     * @param scalar $value
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public static function isValid(bool|int|float|string $value): bool
    {
        // @codeCoverageIgnoreStart
        return true;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param scalar $value
     * @return scalar
     */
    public static function filter(bool|int|float|string $value): bool|int|float|string
    {
        // @codeCoverageIgnoreStart
        return $value;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param mixed $value
     * @return static
     */
    public static function from(mixed $value): static
    {
        if (! (is_int($value) || is_float($value) || is_string($value) || is_bool($value))) {
            throw new InvalidArgumentException(sprintf('Invalid value provided for %s', static::class));
        }
        if (! static::isValid($value)) {
            throw new InvalidArgumentException(sprintf('Invalid value "%s" provided for %s', $value, static::class));
        }
        /** @var ValueType $value */
        $value = static::filter($value);
        if (isset(self::$instances[static::class][$value])) {
            /** @var static $instance */
            $instance = self::$instances[static::class][$value];
            return $instance;
        }

        /** @psalm-suppress UnsafeGenericInstantiation */
        return self::$instances[static::class][$value] = new static($value);
    }

    public function equals(mixed $other): bool
    {
        return $this === $other;
    }

    public function jsonSerialize()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
