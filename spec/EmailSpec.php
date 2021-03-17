<?php

namespace spec\JeckelLab\ValueObject;

use Faker\Factory;
use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\ValueObject\Email;
use PhpSpec\ObjectBehavior;

class EmailSpec extends ObjectBehavior
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    function it_is_initializable()
    {
        $this->beConstructedWith($this->faker->email);
        $this->shouldHaveType(Email::class);
        $this->shouldNotThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_is_not_initializable_with_invalid_email()
    {
        $this->beConstructedWith($this->faker->email . '@@');
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_should_return_the_email()
    {
        $email = $this->faker->email;
        $this->beConstructedWith($email);
        $this->getEmail()->shouldReturn($email);
    }

    function it_validate_equality_object()
    {
        $emailString = $this->faker->email;
        $email = new Email($emailString);
        $this->beConstructedWith($emailString);
        $this->equals($email)->shouldReturn(true);
    }

    function it_validate_equality_string()
    {
        $emailString = $this->faker->email;
        $this->beConstructedWith($emailString);
        $this->equals($emailString)->shouldReturn(true);
    }

    function it_reject_inequality()
    {
        $emailString = $this->faker->email;
        $email = new Email('foo.' . $emailString);
        $this->beConstructedWith($emailString);
        $this->equals($email)->shouldReturn(false);
    }

    function it_reject_equality_on_different_object()
    {
        $this->beConstructedWith($this->faker->email);
        $this->equals(new \stdClass())->shouldReturn(false);
    }

    function it_return_email_as_string()
    {
        $emailString = $this->faker->email;
        $this->beConstructedWith($emailString);
        $this->__toString()->shouldReturn($emailString);
    }
}
