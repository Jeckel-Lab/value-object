<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 17/03/2021
 */

declare(strict_types=1);

namespace JeckelLab\ValueObject\Network;

use JeckelLab\Contract\Domain\Equality;
use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\Contract\Domain\ValueObject\ValueObject;
use JeckelLab\ValueObject\AbstractScalarValueObject;

/**
 * Class IPv4
 * @package JeckelLab\ValueObject\Network
 * @extends AbstractScalarValueObject<string>
 * @psalm-immutable
 */
class IPv4 extends AbstractScalarValueObject
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
        return filter_var(trim($value), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    /**
     * @param int|float|string $value
     * @return int|float|string
     */
    public static function filter(int|float|string $value): int|float|string
    {
        $filteredValue = filter_var(trim((string) $value), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        if (false === $filteredValue) {
            // @codeCoverageIgnoreStart
            throw new InvalidArgumentException(sprintf('Invalid value provided for %s', self::class));
            // @codeCoverageIgnoreEnd
        }
        return $filteredValue;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->value;
    }
}
