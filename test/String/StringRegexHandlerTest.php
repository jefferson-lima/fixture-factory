<?php

namespace Jefferson\Lima\Test\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\String\StringMaxLengthHandler;
use Jefferson\Lima\String\StringRegexHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StringRegexHandlerTest extends TestCase
{
    /** @var StringMaxLengthHandler */
    private $handler;

    /**
     * @var string
     * @Assert\Regex("/[A-Z][a-z]+/")
     */
    private $regexString;

    /** @var ValidatorInterface */
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new StringRegexHandler();
        $this->validator = Validation::createValidator();
    }

    public function testRegexString(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'regexString') ;
        $initialValue = 'abc';

        $value = $this->handler->handle($property, $initialValue);

        $violations = $this->validator->validate($value, new Assert\Regex("/[A-Z][a-z]+/"));
        $this->assertEmpty($violations);
    }
}
