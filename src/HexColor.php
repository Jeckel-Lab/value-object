<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 17/03/2021
 */

declare(strict_types=1);

namespace JeckelLab\ValueObject;

use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;

/**
 * Class HexColor
 * @package JeckelLab\ValueObject
 * @extends AbstractScalarValueObject<string>
 * @psalm-immutable
 */
final class HexColor extends AbstractScalarValueObject
{
    /**
     * @param int|float|string $value
     * @return bool
     */
    public static function isValid(int|float|string $value): bool
    {
        if (! is_string($value)) {
            return false;
        }
        $value = trim($value);
        $re = '/#[0-9a-f]{6}/m';
        $matches = [];
        if (strlen($value) === 6) {
            $value = '#' . $value;
        }

        return (strlen($value) === 7 && 1 === preg_match($re, strtolower($value), $matches));
    }

    /**
     * @param int|float|string $value
     * @return int|float|string
     */
    public static function filter(int|float|string $value): int|float|string
    {
        $value = trim((string) $value);
        $re = '/#[0-9a-f]{6}/m';
        $matches = [];
        if (strlen($value) === 6) {
            $value = '#' . $value;
        }

        if (strlen($value) !== 7 || 1 !== preg_match($re, strtolower($value), $matches)) {
            // @codeCoverageIgnoreStart
            throw new InvalidArgumentException('Invalid hex color provided');
            // @codeCoverageIgnoreEnd
        }
        return $matches[0];
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->value;
    }
}
