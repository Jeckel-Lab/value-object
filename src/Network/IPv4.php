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

/**
 * Class IPv4
 * @package JeckelLab\ValueObject\Network
 * @psalm-immutable
 */
class IPv4 implements ValueObject, Equality
{
    /** @var string */
    protected $ip;

    /**
     * Email constructor.
     * @param string $ip
     */
    public function __construct(string $ip)
    {
        $filteredIp = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        if (false === $filteredIp) {
            throw new InvalidArgumentException('Invalid ip provided');
        }
        $this->ip = $filteredIp;
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
            return $this->ip === $object->ip;
        }
        return $this->ip === (string) $object;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->ip;
    }
}
