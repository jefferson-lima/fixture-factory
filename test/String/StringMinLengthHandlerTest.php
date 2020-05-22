<?php

namespace Jefferson\Lima\Test\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\String\StringMinLengthHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;

class StringMinLengthHandlerTest extends TestCase
{
    /** @var StringMinLengthHandler */
    private $handler;

    /**
     * @var string
     * @Assert\Length(min=300)
     */
    private $minLengthString;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new StringMinLengthHandler();
    }

    public function testMinLengthString(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'minLengthString') ;
        $initialValue = 'abc';

        $value = $this->handler->handle($property, $initialValue);

        $this->assertIsString($value);
        $this->assertTrue(strlen($value) >= 300);
    }
}
