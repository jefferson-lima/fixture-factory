<?php

namespace Jefferson\Lima\Test\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\ValueGenerator\String\StringMaxLengthHandler;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Validator\Constraints as Assert;

class StringMaxLengthHandlerTest extends TestCase
{
    /** @var StringMaxLengthHandler */
    private $handler;

    /**
     * @var string
     * @Assert\Length(max=3)
     */
    private $maxLengthString;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new StringMaxLengthHandler();
    }

    public function testMaxLengthString(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'maxLengthString') ;
        $initialValue = 'abcdef';

        $value = $this->handler->handle($property, $initialValue, new stdClass());

        $this->assertIsString($value);
        $this->assertTrue(strlen($value) <= 300);
    }
}
