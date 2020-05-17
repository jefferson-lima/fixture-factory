<?php

namespace Jefferson\Lima\Test;

use Jefferson\Lima\StringValueGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\Validator\Constraints as Assert;

class StringValueGeneratorTest extends TestCase
{

    /**
     * @var string
     */
    private $simpleString;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $notBlankString;

    /**
     * @var string
     * @Assert\Length(min=300)
     */
    private $minLengthString;

    /**
     * @var string
     * @Assert\Length(max=3)
     */
    private $maxLengthString;

    /**
     * @var string
     * @Assert\Length(min=300, max=303)
     */
    private $minMaxLengthString;

    /** @var StringValueGenerator  */
    private $generator;

    protected function setUp(): void
    {
        $this->generator = new StringValueGenerator();
    }

    public function testSimpleString(): void
    {
        $property = $this->getProperty('simpleString');
        $value = $this->generator->generate($property);
        $this->assertIsString($value);
    }

    public function testNotBlankString(): void
    {
        $property = $this->getProperty('notBlankString');
        $value = $this->generator->generate($property);
        $this->assertIsString($value);
        $this->assertNotEmpty($value);
    }

    public function testMinLengthString(): void
    {
        $property = $this->getProperty('minLengthString');
        $value = $this->generator->generate($property);
        $this->assertIsString($value);
        $this->assertTrue(strlen($value) >= 300);
    }

    public function testMaxLengthString(): void
    {
        $property = $this->getProperty('maxLengthString');
        $value = $this->generator->generate($property);
        $this->assertIsString($value);
        $this->assertTrue(strlen($value) <= 3);
    }

    public function testMinMaxLengthString(): void
    {
        $property = $this->getProperty('minMaxLengthString');
        $value = $this->generator->generate($property);
        $this->assertIsString($value);
        $this->assertTrue(strlen($value) >= 300 && strlen($value) <= 303);
    }

    private function getProperty(string $name): ReflectionProperty
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        return $reflectionClass->getProperty($name);
    }
}
