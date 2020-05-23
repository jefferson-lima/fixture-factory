<?php

namespace Jefferson\Lima\Test;

use InvalidArgumentException as InvalidArgumentExceptionAlias;
use Jefferson\Lima\RandomDataProvider;
use Jefferson\Lima\Reflection\DocType;
use PHPUnit\Framework\TestCase;

class RandomDataProviderTest extends TestCase
{
    /** @var RandomDataProvider */
    private $randomDataProvider;

    protected function setUp(): void
    {
        $this->randomDataProvider = new RandomDataProvider();
    }

    public function testGetRandomNumberWithInvalidType(): void
    {
        $this->expectException(InvalidArgumentExceptionAlias::class);
        $this->randomDataProvider->getRandomNumber(0, 10, 'type');
    }

    public function testGetRandomNumberWithNonNumericMinMax(): void
    {
        $this->expectException(InvalidArgumentExceptionAlias::class);
        $this->randomDataProvider->getRandomNumber(0, 'a', DocType::INT);
    }

    public function testGetRandomNumberInt(): void
    {
        $min = -10;
        $max = 10;

        $number = $this->randomDataProvider->getRandomNumber($min, $max, DocType::INT);

        $this->assertIsInt($number);
        $this->assertTrue($number >= $min && $number <= $max);
    }

    public function testGetRandomNumberFloat(): void
    {
        $min = -10;
        $max = 10;

        $number = $this->randomDataProvider->getRandomNumber($min, $max, DocType::FLOAT);

        $this->assertIsFloat($number);
        $this->assertTrue($number >= $min && $number <= $max);
    }

    public function testGetPositiveInt(): void
    {
        $number = $this->randomDataProvider->getPositiveNumber(DocType::INT);
        $this->assertIsInt($number);
        $this->assertGreaterThan(0, $number);
    }

    public function testGetNegativeInt(): void
    {
        $number = $this->randomDataProvider->getNegativeNumber(DocType::INT);
        $this->assertIsInt($number);
        $this->assertLessThan(0, $number);
    }

    public function testGetPositiveFloat(): void
    {
        $number = $this->randomDataProvider->getPositiveNumber(DocType::FLOAT);
        $this->assertIsFloat($number);
        $this->assertGreaterThan(0, $number);
    }

    public function testGetNegativeFloat(): void
    {
        $number = $this->randomDataProvider->getNegativeNumber(DocType::FLOAT);
        $this->assertIsFloat($number);
        $this->assertLessThan(0, $number);
    }
}
