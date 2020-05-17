<?php

namespace Jefferson\Lima\Test;

use Jefferson\Lima\BooleanValueGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;
use Symfony\Component\Validator\Constraints as Assert;

class BooleanValueGeneratorTest extends TestCase
{

    /** @var bool */
    private $simpleBoolean;

    /**
     * @var bool
     * @Assert\NotBlank()
     */
    private $notBlankBoolean;

    /** @var BooleanValueGenerator */
    private $generator;

    protected function setUp(): void
    {
        $this->generator = new BooleanValueGenerator();
    }

    public function testSimpleBoolean(): void
    {
        $property = $this->getProperty('simpleBoolean');
        $value = $this->generator->generate($property);
        $this->assertFalse($value);
    }

    public function testNotBlankBoolean(): void
    {
        $property = $this->getProperty('notBlankBoolean');
        $value = $this->generator->generate($property);
        $this->assertTrue($value);
    }

    private function getProperty(string $name): ReflectionProperty
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        return $reflectionClass->getProperty($name);
    }

}
