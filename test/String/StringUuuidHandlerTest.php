<?php

namespace Jefferson\Lima\Test\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;
use Jefferson\Lima\String\StringUuidHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StringUuuidHandlerTest extends TestCase
{
    /** @var PropertyAnnotationHandler */
    private $handler;

    /**
     * @var string
     * @Assert\Uuid()
     */
    private $uuidString;

    /** @var ValidatorInterface */
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new StringUuidHandler();
        $this->validator = Validation::createValidator();
    }

    public function testUuidString(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'uuidString') ;
        $initialValue = 'abc';

        $value = $this->handler->handle($property, $initialValue);

        $violations = $this->validator->validate($value, new Assert\Uuid());
        $this->assertEmpty($violations);
    }
}
