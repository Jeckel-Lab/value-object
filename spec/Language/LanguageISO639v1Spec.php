<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 17/03/2021
 */

declare(strict_types=1);

namespace spec\JeckelLab\ValueObject\Language;

use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\ValueObject\Language\LanguageISO639v1;
use PhpSpec\ObjectBehavior;

class LanguageISO639v1Spec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('fr');
        $this->shouldHaveType(LanguageISO639v1::class);
        $this->shouldNotThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_is_not_initializable_with_invalid_code()
    {
        $this->beConstructedWith('foo@bar.com');
        $this->shouldHaveType(LanguageISO639v1::class);
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }
}
