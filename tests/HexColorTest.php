<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 15/12/2021
 */

use JeckelLab\ValueObject\HexColor;
use PHPUnit\Framework\TestCase;

class HexColorTest extends TestCase
{
    /**
     * @param string $value
     * @param string $filteredValue
     * @return void
     * @throws JsonException
     * @dataProvider provideValidHexColorValue
     */
    public function testInitialization(string $value, string $filteredValue): void
    {
        $color = HexColor::from($value);
        $this->assertInstanceOf(HexColor::class, $color);
        $this->assertEquals($filteredValue, $color->getColor());
        $this->assertEquals($filteredValue, (string) $color);
        $this->assertEquals(sprintf('"%s"', $filteredValue), json_encode($color, JSON_THROW_ON_ERROR));
    }

    /**
     * @param mixed $colorValue
     * @return void
     * @dataProvider provideInvalidHexColorValue
     */
    public function testInitializationFailedWithInvalidEmail(mixed $colorValue): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            'Invalid value "%s" provided for %s',
            $colorValue,
            HexColor::class
        ));

        HexColor::from($colorValue);
    }

    public function testEquality(): void
    {
        $color1 = HexColor::from('ff123a');
        $color2 = HexColor::from('#ff123a');
        $this->assertSame($color1, $color2);
        $this->assertTrue($color1->equals($color2));
        $this->assertTrue($color2->equals($color1));
    }

    public function testNotEquality(): void
    {
        $color1 = HexColor::from('ff123a');
        $color2 = HexColor::from('#ff123b');
        $this->assertNotSame($color1, $color2);
        $this->assertFalse($color1->equals($color2));
        $this->assertFalse($color2->equals($color1));
    }

    public function provideValidHexColorValue(): array
    {
        return [
            ['#123456', '#123456'],
            ['123456', '#123456'],
            ['   123456   ', '#123456'],
            ['#abc123', '#abc123'],
            ['#ABC123', '#abc123']
        ];
    }

    /**
     * @return array[]
     */
    public function provideInvalidHexColorValue(): array
    {
        return [
            ['foo@bar.com@'],
            ['foobarbaz'],
            [123],
            [123.23],
            ['#123456#'],
            ['#bvhjkl'],
            ['gfdsgs']
        ];
    }
}
