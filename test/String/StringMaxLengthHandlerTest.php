<?php

namespace Jefferson\Lima\Test\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\String\StringMaxLengthHandler;
use Jefferson\Lima\String\StringMinLengthHandler;
use PHPUnit\Framework\TestCase;
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

        $value = $this->handler->handle($property, $initialValue);

        $this->assertIsString($value);
        $this->assertTrue(strlen($value) <= 300);
    }
}
