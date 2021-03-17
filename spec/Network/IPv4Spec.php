<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 17/03/2021
 */

declare(strict_types=1);

namespace spec\JeckelLab\ValueObject\Network;

use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\ValueObject\Network\IPv4;
use PhpSpec\ObjectBehavior;

class IPv4Spec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('123.123.123.123');
        $this->shouldHaveType(IPv4::class);
        $this->shouldNotThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_not_is_initializable_with_invalid_string()
    {
        $this->beConstructedWith('foobarbaz');
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_not_is_initializable_with_invalid_ip_parts()
    {
        $this->beConstructedWith('123.300.123.123');
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_not_is_initializable_with_ipv6()
    {
        $this->beConstructedWith('FE80:0000:0000:0000:0202:B3FF:FE1E:8329');
        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_should_return_the_ip()
    {
        $ipString = '123.123.123.123';
        $this->beConstructedWith($ipString);
        $this->getIp()->shouldReturn($ipString);
    }

    function it_validate_equality_object()
    {
        $ipString = '123.123.123.123';
        $email = new IPv4($ipString);
        $this->beConstructedWith($ipString);
        $this->equals($email)->shouldReturn(true);
    }

    function it_validate_equality_string()
    {
        $ipString = '123.123.123.123';
        $this->beConstructedWith($ipString);
        $this->equals($ipString)->shouldReturn(true);
    }

    function it_reject_inequality()
    {
        $email = new IPv4('123.123.123.124');
        $this->beConstructedWith('123.123.123.123');
        $this->equals($email)->shouldReturn(false);
    }

    function it_reject_equality_on_different_object()
    {
        $this->beConstructedWith('123.123.123.124');
        $this->equals(new \stdClass())->shouldReturn(false);
    }

    function it_return_email_as_string()
    {
        $ipString = '123.123.123.123';
        $this->beConstructedWith($ipString);
        $this->__toString()->shouldReturn($ipString);
    }
}
