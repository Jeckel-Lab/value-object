<?php

namespace spec\JeckelLab\ValueObject;

use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\ValueObject\Email;
use PhpSpec\ObjectBehavior;

class EmailSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('foo@bar.com');
        $this->shouldHaveType(Email::class);
        $this->shouldNotThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_is_not_initializable_with_invalid_email()
    {
        $this->beConstructedWith('foo@bar.com@');
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_should_return_the_email()
    {
        $email = 'foo@bar.com';
        $this->beConstructedWith($email);
        $this->getEmail()->shouldReturn($email);
    }

    function it_validate_equality_object()
    {
        $emailString = 'foo@bar.com';
        $email = new Email($emailString);
        $this->beConstructedWith($emailString);
        $this->equals($email)->shouldReturn(true);
    }

    function it_validate_equality_string()
    {
        $emailString = 'foo@bar.com';
        $this->beConstructedWith($emailString);
        $this->equals($emailString)->shouldReturn(true);
    }

    function it_reject_inequality()
    {
        $emailString = 'foo@bar.com';
        $email = new Email('foo.' . $emailString);
        $this->beConstructedWith($emailString);
        $this->equals($email)->shouldReturn(false);
    }

    function it_reject_equality_on_different_object()
    {
        $this->beConstructedWith('foo@bar.com');
        $this->equals(new \stdClass())->shouldReturn(false);
    }

    function it_return_email_as_string()
    {
        $emailString = 'foo@bar.com';
        $this->beConstructedWith($emailString);
        $this->__toString()->shouldReturn($emailString);
    }
}
