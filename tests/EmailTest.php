<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 15/12/2021
 */

use JeckelLab\Contract\Domain\ValueObject\Exception\InvalidArgumentException;
use JeckelLab\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testInitialization(): void
    {
        $email = Email::from('foo@bar.com');
        $this->assertInstanceOf(Email::class, $email);
        $this->assertEquals('foo@bar.com', $email->getEmail());
        $this->assertEquals('foo@bar.com', (string) $email);
        $this->assertEquals('"foo@bar.com"', json_encode($email, JSON_THROW_ON_ERROR));
    }

    public function testInitializationWithSpaces(): void
    {
        $email = Email::from('  foo@bar.com  ');
        $this->assertInstanceOf(Email::class, $email);
        $this->assertEquals('foo@bar.com', $email->getEmail());
        $this->assertEquals('foo@bar.com', (string) $email);
        $this->assertEquals('"foo@bar.com"', json_encode($email, JSON_THROW_ON_ERROR));
    }

    /**
     * @param mixed $emailValue
     * @return void
     * @dataProvider provideInvalidEmailValue
     */
    public function testInitializationFailedWithInvalidEmail(mixed $emailValue): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            'Invalid value "%s" provided for %s',
            $emailValue,
            Email::class
        ));

        Email::from($emailValue);
    }

    public function testEquality(): void
    {
        $email1 = Email::from('foo@bar.com');
        $email2 = Email::from('  foo@bar.com');
        $this->assertSame($email1, $email2);
        $this->assertTrue($email1->equals($email2));
        $this->assertTrue($email2->equals($email1));
    }

    public function testNotEquality(): void
    {
        $email1 = Email::from('foo@bar.com');
        $email2 = Email::from('  foo@bar.net');
        $this->assertNotSame($email1, $email2);
        $this->assertFalse($email1->equals($email2));
        $this->assertFalse($email2->equals($email1));
    }

    /**
     * @return array<array[]>
     */
    public function provideInvalidEmailValue(): array
    {
        return [
            ['foo@bar.com@'],
            ['foobarbaz'],
            [123],
            [123.23],
        ];
    }
}
