<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 17/03/2021
 */

declare(strict_types=1);

namespace JeckelLab\ValueObject;

/**
 * Class Email
 * @package JeckelLab\ValueObject
 * @extends AbstractScalarValueObject<string>
 * @psalm-immutable
 */
final class Email extends AbstractScalarValueObject
{
    /**
     * @param float|bool|int|string $value
     * @psalm-param string
     * @return bool
     */
    public static function isValid(float|bool|int|string $value): bool
    {
        if (! is_string($value)) {
            return false;
        }
        return filter_var(trim($value), FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * @param float|bool|int|string $value
     * @psalm-param string
     * @return bool|int|float|string
     * @psalm-return string
     */
    public static function filter(float|bool|int|string $value): bool|int|float|string
    {
        return filter_var(trim((string) $value), FILTER_VALIDATE_EMAIL);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->value;
    }
}
