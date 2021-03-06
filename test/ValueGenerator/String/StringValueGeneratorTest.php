<?php

namespace Jefferson\Lima\Test\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\ValueGenerator\String\StringValueGenerator;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use stdClass;
use Symfony\Component\Validator\Constraint;
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
     * @Assert\Email
     */
    private $emailString;

    /**
     * @var string
     * @Assert\Regex("/[A-Z][a-z]+/")
     */
    private $regexString;

    /**
     * @var string
     * @Assert\Uuid()
     */
    private $uuidString;

    /**
     * @var string
     * @Assert\Url()
     */
    private $urlString;

    /**
     * @var string
     * @Assert\Date()
     */
    private $dateString;

    /**
     * @var string
     * @Assert\DateTime(format="d-m-Y H:i:s")
     */
    private $datetimeString;

    /**
     * @var string
     * @Assert\Choice(choices={"red", "blue", "green"})
     */
    private $choiceString;

    /**
     * @var string
     * @Assert\Length(min=300, max=303)
     * @Assert\Email
     * @Assert\Regex("/[A-Z][a-z]+/")
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
        $value = $this->generator->generate($property, new stdClass());
        $this->assertIsString($value);
    }

    public function constraintDataProvider(): array
    {
        return [
          "@NotBlank" => ['notBlankString', new Assert\NotBlank()],
          "@Length" => ['minMaxLengthString', new Assert\Length(["min" => 300, "max" => 303])],
          "@Email" => ['emailString', new Assert\Email()],
          "@Regex" => ['regexString', new Assert\Regex("/[A-Z][a-z]+/")],
          "@Uuid" => ['uuidString', new Assert\Uuid()],
          "@Url" => ['urlString', new Assert\Url()],
          "@Date" => ['dateString', new Assert\Date()],
          "@Datetime" => ['datetimeString', new Assert\DateTime(['format' => 'd-m-Y H:i:s'])],
          "@Choice" => ['choiceString', new Assert\Choice(['choices' => ["red", "blue", "green"]])],
        ];
    }

    /**
     * @dataProvider constraintDataProvider
     * @param string $property
     * @param Constraint $constraint
     * @throws ReflectionException
     */
    public function testConstraints(string $property, Constraint $constraint): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, $property) ;
        $value = $this->generator->generate($property, new stdClass());
        $violations = $this->validator->validate($value, $constraint);
        $this->assertEmpty($violations);
    }
}
