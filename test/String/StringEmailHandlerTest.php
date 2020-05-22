<?php

namespace Jefferson\Lima\Test\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\String\StringEmailHandler;
use Jefferson\Lima\String\StringMaxLengthHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StringEmailHandlerTest extends TestCase
{
    /** @var StringMaxLengthHandler */
    private $handler;

    /**
     * @var string
     * @Assert\Email()
     */
    private $emailString;

    /** @var ValidatorInterface */
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new StringEmailHandler();
        $this->validator = Validation::createValidator();
    }

    public function testEmailString(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'emailString') ;
        $initialValue = 'abc';

        $value = $this->handler->handle($property, $initialValue);

        $violations = $this->validator->validate($value, new Assert\Email());
        $this->assertEmpty($violations);
    }
}
