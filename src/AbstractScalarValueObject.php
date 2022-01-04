<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 15/12/2021
 */

declare(strict_types=1);

namespace JeckelLab\ValueObject;

use JeckelLab\Contract\Domain\Equality;
use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\Contract\Domain\ValueObject\ValueObject;
use JeckelLab\Contract\Domain\ValueObject\ValueObjectFactory;
use JsonSerializable;
use Stringable;

/**
 * Class AbstractValueObject
 * @package JeckelLab\ValueObject
 * @psalm-immutable
 * @template ValueType of int|float|string
 */
abstract class AbstractScalarValueObject implements
    ValueObject,
    ValueObjectFactory,
    Stringable,
    JsonSerializable,
    Equality
{
    /**
     * @var ValueType
     */
    protected int|float|string $value;

    /**
     * @var array<
     *     class-string<AbstractScalarValueObject<int|float|string>>,
     *     array<int|float|string, AbstractScalarValueObject<int|float|string>>
     * >
     */
    private static array $instances = [];

    /**
     * @param ValueType $value
     */
    final private function __construct(int|float|string $value)
    {
        $this->value = $value;
    }

    /**
     * @param int|float|string $value
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public static function isValid(int|float|string $value): bool
    {
        // @codeCoverageIgnoreStart
        return true;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param int|float|string $value
     * @return int|float|string
     */
    public static function filter(int|float|string $value): int|float|string
    {
        // @codeCoverageIgnoreStart
        return $value;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param mixed $value
     * @return static
     * @psalm-suppress MixedArrayTypeCoercion
     * @psalm-suppress MixedPropertyTypeCoercion
     */
    public static function from(mixed $value): static
    {
        if (! (is_int($value) || is_float($value) || is_string($value))) {
            throw new InvalidArgumentException(sprintf(
                'Invalid value type provided for %s (expected int|float|string)',
                static::class
            ));
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

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
