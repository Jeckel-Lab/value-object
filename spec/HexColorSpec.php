<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 17/03/2021
 */

declare(strict_types=1);

namespace spec\JeckelLab\ValueObject;

use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\ValueObject\HexColor;
use PhpSpec\ObjectBehavior;

class HexColorSpec extends ObjectBehavior
{
    function it_is_initializeable()
    {
        $this->beConstructedWith('#ff123a');
        $this->shouldHaveType(HexColor::class);
        $this->shouldNotThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_is_initializeable_short_color()
    {
        $this->beConstructedWith('ff123a');
        $this->shouldHaveType(HexColor::class);
        $this->shouldNotThrow(InvalidArgumentException::class)->duringInstantiation();
        $this->getColor()->shouldReturn('#ff123a');
    }

    function it_is_not_initializeable_with_invalid_color_length()
    {
        $this->beConstructedWith('#ff123a#');
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_is_not_initializeable_with_invalid_color_string_1()
    {
        $this->beConstructedWith('#ff1#23');
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_is_not_initializeable_with_invalid_color_string_2()
    {
        $this->beConstructedWith('#ff123g');
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_should_return_the_color()
    {
        $this->beConstructedWith('#FF123A');
        $this->getColor()->shouldReturn('#ff123a');
    }

    function it_return_color_as_string()
    {
        $color = '#ff123a';
        $this->beConstructedWith($color);
        $this->__toString()->shouldReturn($color);
    }

    function it_validate_object_equality()
    {
        $colorString = '#ff123a';
        $colorObj = new HexColor($colorString);
        $this->beConstructedWith($colorString);
        $this->equals($colorObj)->shouldReturn(true);
    }

    function it_validate_color_equality()
    {
        $colorString = '#ff123a';
        $this->beConstructedWith($colorString);
        $this->equals($colorString)->shouldReturn(true);
    }

    function it_reject_object_inequality()
    {
        $colorObj = new HexColor('#ff123a');
        $this->beConstructedWith('#ff123b');
        $this->equals($colorObj)->shouldReturn(false);
    }

    function it_reject_equality_on_different_object()
    {
        $this->beConstructedWith('#ff123a');
        $this->equals(new \stdClass())->shouldReturn(false);
    }

    function it_reject_color_inequality()
    {
        $this->beConstructedWith('#ff123a');
        $this->equals('#ff123b')->shouldReturn(false);
    }
}
