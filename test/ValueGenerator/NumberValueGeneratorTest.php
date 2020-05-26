<?php

namespace Jefferson\Lima\Test\ValueGenerator;

use Jefferson\Lima\Reflection\DocType;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\ValueGenerator\NumberValueGenerator;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Negative;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NumberValueGeneratorTest extends TestCase
{
    /** @var ValidatorInterface */
    private $validator;

    /** @var int */
    private $simpleInt;

    /** @var float */
    private $simpleFloat;

    /**
     * @var int
     * @Positive
     */
    private $positiveInt;

    /**
     * @var float
     * @Positive
     */
    private $positiveFloat;

    /**
     * @var int
     * @Negative
     */
    private $negativeInt;

    /**
     * @var int
     * @Negative
     */
    private $negativeFloat;

    /** @var NumberValueGenerator */
    private $intGenerator;

    /** @var NumberValueGenerator */
    private $floatGenerator;

    protected function setUp(): void
    {
        $this->intGenerator = new NumberValueGenerator(DocType::INT);
        $this->floatGenerator = new NumberValueGenerator(DocType::FLOAT);
        $this->validator = Validation::createValidator();
    }

    public function testConstructWithInvalidType(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NumberValueGenerator('invalid type');
    }

    public function testSimpleInt(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'simpleInt');
        $value = $this->intGenerator->generate($property);
        $this->assertIsInt($value);
    }

    public function testSimpleFloat(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'simpleFloat');
        $value = $this->floatGenerator->generate($property);
        $this->assertIsFloat($value);
    }

    public function constraintDataProvider(): array
    {
        return [
            "@Positive int" => ['positiveInt', DocType::INT, new Positive()],
            "@Positive float" => ['positiveFloat', DocType::FLOAT, new Positive()],
            "@Negative int" => ['negativeInt', DocType::INT, new Negative()],
            "@Negative float" => ['negativeFloat', DocType::FLOAT, new Negative()],
        ];
    }

    /**
     * @dataProvider constraintDataProvider
     * @param string $property
     * @param string $type
     * @param Constraint $constraint
     * @throws \ReflectionException
     */
    public function testConstraints(string $property, string $type, Constraint $constraint): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, $property) ;

        if (DocType::INT === $type) {
            $value = $this->intGenerator->generate($property);
            $this->assertIsInt($value);
        } else {
            $value = $this->floatGenerator->generate($property);
            $this->assertIsFloat($value);
        }

        $violations = $this->validator->validate($value, $constraint);
        $this->assertEmpty($violations);
    }
}
