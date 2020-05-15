<?php

namespace Jefferson\Lima\Test;

use Jefferson\Lima\StringValueGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\Validator\Constraints as Assert;

class StringValueGeneratorTest extends TestCase
{

    /** @var string */
    private $simpleString;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $notBlankString;

    /** @var StringValueGenerator */
    private $generator;

    protected function setUp(): void
    {
        $this->generator = new StringValueGenerator();
    }

    public function testSimpleString(): void
    {
        $property = $this->getProperty('simpleString');
        $value = $this->generator->generate($property);
        $this->assertTrue(is_string($value));
    }

    public function testNotBlankString(): void
    {
        $property = $this->getProperty('notBlankString');
        $value = $this->generator->generate($property);
        $this->assertTrue(is_string($value));
        $this->assertFalse(empty($value));
    }

    private function getProperty(string $name): ReflectionProperty
    {
        $reflectionClass = new ReflectionClass(get_class());
        return $reflectionClass->getProperty($name);
    }

}
