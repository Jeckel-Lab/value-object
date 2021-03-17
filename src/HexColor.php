<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 17/03/2021
 */

declare(strict_types=1);

namespace JeckelLab\ValueObject;

use JeckelLab\Contract\Domain\Equality;
use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\Contract\Domain\ValueObject\ValueObject;

/**
 * Class HexColor
 * @package JeckelLab\ValueObject
 * @psalm-immutable
 */
final class HexColor implements ValueObject, Equality
{
    /**
     * @var string
     */
    protected $color;

    public function __construct(string $color)
    {
        $re = '/#[0-9a-f]{6}/m';
        $matches = [];
        if (1 !== preg_match($re, strtolower($color), $matches)) {
            throw new InvalidArgumentException('Invalid hex color provided');
        }
        $this->color = $matches[0];
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param mixed $object
     * @return bool
     */
    public function equals($object): bool
    {
        if (is_object($object)) {
            if (! $object instanceof self) {
                return false;
            }
            return $this->color === $object->color;
        }
        return $this->color === strtolower((string) $object);
    }

    public function __toString(): string
    {
        return $this->color;
    }
}
