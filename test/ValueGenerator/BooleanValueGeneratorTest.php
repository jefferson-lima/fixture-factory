<?php

namespace Jefferson\Lima\Test\ValueGenerator;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\ValueGenerator\BooleanValueGenerator;
use PHPUnit\Framework\TestCase;
use stdClass;
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
        $property = new DocTypedReflectionProperty(__CLASS__, 'simpleBoolean');
        $value = $this->generator->generate($property, new stdClass());
        $this->assertFalse($value);
    }

    public function testNotBlankBoolean(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'notBlankBoolean');
        $value = $this->generator->generate($property, new stdClass());
        $this->assertTrue($value);
    }
}
