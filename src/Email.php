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
 * Class Email
 * @package JeckelLab\ValueObject
 * @psalm-immutable
 */
final class Email implements ValueObject, Equality
{
    /** @var string */
    protected $email;

    /**
     * Email constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $filteredEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (false === $filteredEmail) {
            throw new InvalidArgumentException('Invalid email provided');
        }
        $this->email = $filteredEmail;
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
            return $this->email === $object->email;
        }
        return $this->email === (string) $object;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->email;
    }
}
