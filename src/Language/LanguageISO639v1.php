<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 17/03/2021
 */

declare(strict_types=1);

namespace JeckelLab\ValueObject\Language;

use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\Contract\Domain\ValueObject\ValueObject;

/**
 * Class LanguageISO639v1
 * @package JeckelLab\ValueObject\Language
 * @psalm-immutable
 */
class LanguageISO639v1 implements ValueObject
{
    /** @var string */
    protected $value;

    /**
     * LanguageISO639v1 constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (! $this->isValid($value)) {
            throw new InvalidArgumentException('Invalid language provided');
        }
        $this->value = strtolower($value);
    }

    public function isValid(string $value): bool
    {
        $re = '/[a-z]{2}/m';
        $matches = [];

        return !(strlen($value) !== 2 || 1 !== preg_match($re, strtolower($value), $matches));
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
