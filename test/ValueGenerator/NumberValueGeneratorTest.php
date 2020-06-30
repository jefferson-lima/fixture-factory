<?php

namespace Jefferson\Lima\Test\ValueGenerator;

use Jefferson\Lima\Reflection\DocType;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\ValueGenerator\NumberValueGenerator;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use stdClass;

class NumberValueGeneratorTest extends TestCase
{
    /** @var int */
    private $simpleInt;

    /** @var float */
    private $simpleFloat;

    /** @var NumberValueGenerator */
    private $intGenerator;

    /** @var NumberValueGenerator */
    private $floatGenerator;

    protected function setUp(): void
    {
        $this->intGenerator = new NumberValueGenerator(DocType::INT);
        $this->floatGenerator = new NumberValueGenerator(DocType::FLOAT);
    }

    public function testConstructWithInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NumberValueGenerator('invalid type');
    }

    public function testSimpleInt(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'simpleInt');
        $value = $this->intGenerator->generate($property, new stdClass());
        $this->assertIsInt($value);
    }

    public function testSimpleFloat(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'simpleFloat');
        $value = $this->floatGenerator->generate($property, new stdClass());
        $this->assertIsFloat($value);
    }
}
