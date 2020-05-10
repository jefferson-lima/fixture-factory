<?php

namespace Jefferson\Lima\Test;

use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\FixtureFactoryException;
use PHPUnit\Framework\TestCase;

class SimpleTypeTest extends TestCase
{
    public function testCreateFixtureWithInvalidClass(): void
    {
        $this->expectException(FixtureFactoryException::class);
        FixtureFactory::createFixture('invalid class');
    }

    public function createFixtureDataProvider(): array
    {
        return [
            'nonAnnotatedAttr' => ['nonAnnotatedAttr', 'is_null'],
            'invalidVarTagAttr' => ['invalidVarTagAttr', 'is_null'],
            'stringAttr' => ['stringAttr', 'is_string'],
            'integerAttr' => ['integerAttr', 'is_int'],
            'intAttr' => ['intAttr', 'is_int'],
            'boolAttr' => ['boolAttr', 'is_bool'],
            'booleanAttr' => ['booleanAttr', 'is_bool'],
            'floatAttr' => ['floatAttr', 'is_float'],
            'doubletAttr' => ['doubletAttr', 'is_float'],
            'arrayAttr' => ['arrayAttr', 'is_array'],
            'multipleTypesAttr' => ['multipleTypesAttr', 'is_string'],
        ];
    }

    /**
     * @dataProvider createFixtureDataProvider
     * @param string $property
     * @param string $assertFunction
     */
    public function testCreateFixtureAssertPropertyType(string $property, string $assertFunction): void
    {
        $fixture = FixtureFactory::createFixture(SimpleTypeTestObject::class);
        $this->assertTrue($fixture instanceof SimpleTypeTestObject);
        $this->assertTrue($assertFunction($fixture->$property));
    }

    public function testCreateFixtureAssertNonRepeatedValues()
    {
        $fixture1 = FixtureFactory::createFixture(SimpleTypeTestObject::class);
        $fixture2 = FixtureFactory::createFixture(SimpleTypeTestObject::class);

        $this->assertNotEquals($fixture1->stringAttr, $fixture2->stringAttr);
        $this->assertNotEquals($fixture1->integerAttr, $fixture2->integerAttr);
        $this->assertNotEquals($fixture1->intAttr, $fixture2->intAttr);
        $this->assertNotEquals($fixture1->floatAttr, $fixture2->floatAttr);
        $this->assertNotEquals($fixture1->doubletAttr, $fixture2->doubletAttr);
    }
}
