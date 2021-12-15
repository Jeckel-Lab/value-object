<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 15/12/2021
 */

namespace Network;

use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\ValueObject\Network\IPv4;
use PHPUnit\Framework\TestCase;

class IPv4Test extends TestCase
{
    /**
     * @param string $value
     * @param string $filteredValue
     * @return void
     * @throws JsonException
     * @dataProvider provideValidIPv4Value
     */
    public function testInitialization(string $value, string $filteredValue): void
    {
        $ipAddress = IPv4::from($value);
        $this->assertInstanceOf(IPv4::class, $ipAddress);
        $this->assertEquals($filteredValue, $ipAddress->getIp());
        $this->assertEquals($filteredValue, (string) $ipAddress);
        $this->assertEquals(sprintf('"%s"', $filteredValue), json_encode($ipAddress, JSON_THROW_ON_ERROR));
    }

    /**
     * @param mixed $ipAddressValue
     * @return void
     * @dataProvider provideInvalidIPv4Value
     */
    public function testInitializationFailedWithInvalidEmail(mixed $ipAddressValue): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            'Invalid value "%s" provided for %s',
            $ipAddressValue,
            IPv4::class
        ));

        IPv4::from($ipAddressValue);
    }

    public function testEquality(): void
    {
        $ipAddress1 = IPv4::from('123.123.123.124');
        $ipAddress2 = IPv4::from('  123.123.123.124  ');
        $this->assertSame($ipAddress1, $ipAddress2);
        $this->assertTrue($ipAddress1->equals($ipAddress2));
        $this->assertTrue($ipAddress2->equals($ipAddress1));
    }

    public function testNotEquality(): void
    {
        $ipAddress1 = IPv4::from('123.123.123.124');
        $ipAddress2 = IPv4::from('  123.123.123.125  ');
        $this->assertNotSame($ipAddress1, $ipAddress2);
        $this->assertFalse($ipAddress1->equals($ipAddress2));
        $this->assertFalse($ipAddress2->equals($ipAddress1));
    }


    public function provideValidIPv4Value(): array
    {
        return [
            ['123.123.123.123', '123.123.123.123'],
            ['   123.123.123.123  ', '123.123.123.123'],
        ];
    }

    /**
     * @return array[]
     */
    public function provideInvalidIPv4Value(): array
    {
        return [
            ['foo@bar.com@'],
            ['foobarbaz'],
            [123],
            [123.23],
            [true],
            ['#123456#'],
            ['#bvhjkl'],
            ['gfdsgs'],
            ['123.300.123.123'],    // invalid IPv4 format
            ['FE80:0000:0000:0000:0202:B3FF:FE1E:8329']     // IPv6
        ];
    }
}
