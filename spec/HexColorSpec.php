<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 17/03/2021
 */

declare(strict_types=1);

namespace spec\JeckelLab\ValueObject;

use Faker\Factory;
use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\ValueObject\HexColor;
use PhpSpec\ObjectBehavior;

class HexColorSpec extends ObjectBehavior
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    function it_is_initializeable()
    {
        $this->beConstructedWith($this->faker->hexColor);
        $this->shouldHaveType(HexColor::class);
        $this->shouldNotThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_is_not_initializeable_with_invalid_color()
    {
        $this->beConstructedWith($this->faker->email);
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_should_return_the_color()
    {
        $this->beConstructedWith('#FF123A');
        $this->getColor()->shouldReturn('#ff123a');
    }

    function it_return_color_as_string()
    {
        $color = $this->faker->hexColor;
        $this->beConstructedWith($color);
        $this->__toString()->shouldReturn($color);
    }

    function it_validate_object_equality()
    {
        $colorString = $this->faker->hexColor;
        $colorObj = new HexColor($colorString);
        $this->beConstructedWith($colorString);
        $this->equals($colorObj)->shouldReturn(true);
    }

    function it_validate_color_equality()
    {
        $colorString = $this->faker->hexColor;
        $this->beConstructedWith($colorString);
        $this->equals($colorString)->shouldReturn(true);
    }

    function it_reject_object_inequality()
    {
        $colorObj = new HexColor($this->faker->hexColor);
        $this->beConstructedWith($this->faker->hexColor);
        $this->equals($colorObj)->shouldReturn(false);
    }

    function it_reject_equality_on_different_object()
    {
        $this->beConstructedWith($this->faker->hexColor);
        $this->equals(new \stdClass())->shouldReturn(false);
    }

    function it_reject_color_inequality()
    {
        $this->beConstructedWith($this->faker->hexColor);
        $this->equals($this->faker->hexColor)->shouldReturn(false);
    }
}
