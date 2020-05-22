<?php

namespace Jefferson\Lima\Test;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\String\StringValueGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class StringValueGeneratorTest extends TestCase
{
    /** @var ValidatorInterface */
    private $validator;

    /**
     * @var string
     */
    private $simpleString;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $notBlankString;

    /**
     * @var string
     * @Assert\Length(min=300, max=303)
     */
    private $minMaxLengthString;

    /**
     * @var string
     * @Assert\Length(min=300, max=303)
     * @Assert\Email
     */
    private $multipleAnnotationAttr;

    /** @var StringValueGenerator  */
    private $generator;

    protected function setUp(): void
    {
        $this->generator = new StringValueGenerator();
        $this->validator = Validation::createValidator();
    }

    public function testSimpleString(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'simpleString') ;
        $value = $this->generator->generate($property);
        $this->assertIsString($value);
    }

    public function testNotBlankString(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'notBlankString') ;
        $value = $this->generator->generate($property);
        $this->assertIsString($value);
        $this->assertNotEmpty($value);
    }

    public function testMinMaxLengthString(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'minMaxLengthString') ;
        $value = $this->generator->generate($property);
        $this->assertIsString($value);
        $this->assertTrue(strlen($value) >= 300 && strlen($value) <= 303);
    }

    public function testMultipleAnnotations(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'multipleAnnotationAttr') ;
        $value = $this->generator->generate($property);

        $violations = $this->validator->validate($value, new Assert\Email());
        $this->assertEmpty($violations);
    }
}
