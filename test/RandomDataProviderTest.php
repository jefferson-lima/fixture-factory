<?php

namespace Jefferson\Lima\Test;

use DateTime;
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

    public function testGetDateString(): void
    {
        $date = $this->randomDataProvider->getDateString();
        $this->assertNotFalse(DateTime::createFromFormat('Y-m-d', $date));
    }

    public function testGetDatetimeString(): void
    {
        $format = 'Y-m-d H:i:s';
        $datetime = $this->randomDataProvider->getDatetimeString($format);
        $this->assertNotFalse(DateTime::createFromFormat($format, $datetime));
    }

    public function testGetEmail(): void
    {
        $email = $this->randomDataProvider->getEmail();
        $this->assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    public function testGetUuid(): void
    {
        $uuidRegex = '/^[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}$/';

        $uuid = $this->randomDataProvider->getUuid();
        $this->assertMatchesRegularExpression($uuidRegex, $uuid);
    }

    public function testGetUrl(): void
    {
        $url = $this->randomDataProvider->getUrl();
        $this->assertNotFalse(filter_var($url, FILTER_VALIDATE_URL));
    }

    public function testGetRegex(): void
    {
        $uuidRegex = '/^[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}$/';

        $uuid = $this->randomDataProvider->getRegex($uuidRegex);
        $this->assertMatchesRegularExpression($uuidRegex, $uuid);
    }
}
