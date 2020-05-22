<?php

namespace Jefferson\Lima\Test\Reflection;

use Jefferson\Lima\Reflection\DocType;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use PHPUnit\Framework\TestCase;
use ReflectionException as ReflectionExceptionAlias;
use Symfony\Component\Validator\Constraints\Email;

class DocTypedReflectionPropertyTest extends TestCase
{
    private $nonAnnotatedAttr;

    /** @var  */
    private $invalidVarTagAttr;

    /** @var string */
    private $singleTypesAttr;

    /** @var int|string|null */
    private $multipleTypesAttr;

    /** @Email  */
    private $annotatedAttr;

    public function hasVarTypeDataProvider(): array
    {
        return [
            'nonAnnotatedAttr' => ['nonAnnotatedAttr', false],
            'invalidVarTagAttr' => ['invalidVarTagAttr', false],
            'singleTypesAttr' => ['singleTypesAttr', true],
            'multipleTypesAttr' => ['multipleTypesAttr', true],
        ];
    }

    /**
     * @dataProvider hasVarTypeDataProvider
     * @param string $property
     * @param bool $expectedResult
     * @throws ReflectionExceptionAlias
     */
    public function testHasVarType(string $property, bool $expectedResult): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, $property);
        $this->assertEquals($expectedResult, $property->hasVarType());
    }

    public function getVarTypeDataProvider(): array
    {
        return [
            'nonAnnotatedAttr' => ['nonAnnotatedAttr', null],
            'invalidVarTagAttr' => ['invalidVarTagAttr', null],
            'singleTypesAttr' => ['singleTypesAttr', DocType::STRING],
            'multipleTypesAttr' => ['multipleTypesAttr', DocType::INT],
        ];
    }

    /**
     * @dataProvider getVarTypeDataProvider
     * @param string $property
     * @param string $expectedType
     * @throws ReflectionExceptionAlias
     */
    public function testGetVarType(string $property, ?string $expectedType): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, $property);
        $actualType = $property->getVarType();
        $this->assertEquals($expectedType, $actualType);
    }

    public function testGetAnnotationWithNonAnnotatedAttr(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'nonAnnotatedAttr');
        $this->assertNull($property->getAnnotation(Email::class));
    }

    public function testGetAnnotationWithAnnotatedAttr(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'annotatedAttr');
        $this->assertNotNull($property->getAnnotation(Email::class));
    }
}
