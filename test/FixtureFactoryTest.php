<?php

namespace Jefferson\Lima\Test;

use Doctrine\Common\Collections\Collection;
use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\FixtureFactoryException;
use Jefferson\Lima\Test\TestObject\CircularReferenceTestObject;
use Jefferson\Lima\Test\TestObject\ManyToOneBidirectional;
use Jefferson\Lima\Test\TestObject\ManyToOneUnidirectional;
use Jefferson\Lima\Test\TestObject\OneToManyBidirectional;
use Jefferson\Lima\Test\TestObject\OneToManyUnidirectional;
use Jefferson\Lima\Test\TestObject\NestedTestObject;
use Jefferson\Lima\Test\TestObject\OneToOneA;
use Jefferson\Lima\Test\TestObject\OneToOneB;
use Jefferson\Lima\Test\TestObject\OneToOneC;
use Jefferson\Lima\Test\TestObject\TestObject;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class FixtureFactoryTest extends TestCase
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
     * @throws ReflectionException
     */
    public function testCreateFixtureAssertPropertyType(string $property, string $assertFunction): void
    {
        $fixture = FixtureFactory::createFixture(TestObject::class);
        $this->assertInstanceOf(TestObject::class, $fixture);
        $this->assertTrue($assertFunction($fixture->$property));
    }

    public function testCreateFixtureAssertNonRepeatedValues(): void
    {
        $fixture1 = FixtureFactory::createFixture(TestObject::class);
        $fixture2 = FixtureFactory::createFixture(TestObject::class);

        $this->assertNotEquals($fixture1->stringAttr, $fixture2->stringAttr);
        $this->assertNotEquals($fixture1->integerAttr, $fixture2->integerAttr);
        $this->assertNotEquals($fixture1->intAttr, $fixture2->intAttr);
        $this->assertNotEquals($fixture1->floatAttr, $fixture2->floatAttr);
        $this->assertNotEquals($fixture1->doubletAttr, $fixture2->doubletAttr);
    }

    public function testNestedObject(): void
    {
        $fixture = FixtureFactory::createFixture(TestObject::class);

        $this->assertInstanceOf(NestedTestObject::class, $fixture->objAttr);
        $this->assertIsString($fixture->objAttr->getStringAttr());
        $this->assertIsInt($fixture->objAttr->getIntAttr());
    }

    public function testCircularReference(): void
    {
        $this->expectException(FixtureFactoryException::class);
        FixtureFactory::createFixture(CircularReferenceTestObject::class);
    }

    public function testOverrideAttribute(): void
    {
        $stringAttr = 'overridden attribute';
        $floatAttr = 0.5;

        $fixture = FixtureFactory::createFixture(
            TestObject::class,
            ['stringAttr' => $stringAttr, 'floatAttr' => $floatAttr]
        );

        $this->assertEquals($stringAttr, $fixture->stringAttr);
        $this->assertEquals($floatAttr, $fixture->floatAttr);
    }

    public function testCircularReferenceWithOverriddenAttribute(): void
    {
        $fixture = FixtureFactory::createFixture(
            CircularReferenceTestObject::class,
            ['backReference' => null]
        );

        $this->assertNull($fixture->getBackReference());
        $this->assertNotNull($fixture->getNonCircularReference());
    }

    public function testOneToOne(): void
    {
        $fixture = FixtureFactory::createFixture(OneToOneA::class);

        $this->assertInstanceOf(OneToOneA::class, $fixture);
        $this->assertInstanceOf(OneToOneB::class, $fixture->oneToOneBInversedBy);
        $this->assertInstanceOf(OneToOneC::class, $fixture->oneToOneCMappedBy);
        $this->assertInstanceOf(TestObject::class, $fixture->oneToOneUnidirectional);

        $this->assertEquals($fixture, $fixture->oneToOneBInversedBy->oneToOneAMappedBy);
        $this->assertEquals($fixture, $fixture->oneToOneCMappedBy->oneToOneAInversedBy);
    }

    public function testOneToManyUnidirectional(): void
    {
        $fixture = FixtureFactory::createFixture(OneToManyUnidirectional::class);

        $this->assertInstanceOf(OneToManyUnidirectional::class, $fixture);
        $this->assertInstanceOf(Collection::class, $fixture->oneToManyUnidirectional);

        foreach ($fixture->oneToManyUnidirectional as $element) {
            $this->assertInstanceOf(TestObject::class, $element);
        }
    }

    public function testManyToOne(): void
    {
        $fixture = FixtureFactory::createFixture(ManyToOneUnidirectional::class);

        $this->assertInstanceOf(ManyToOneUnidirectional::class, $fixture);
        $this->assertInstanceOf(TestObject::class, $fixture->manyToOneUnidirectional);
    }

    public function testOneToManyBidirectional(): void
    {
        $fixture = FixtureFactory::createFixture(OneToManyBidirectional::class);

        $this->assertInstanceOf(OneToManyBidirectional::class, $fixture);
        $this->assertInstanceOf(Collection::class, $fixture->oneToManyBidirectional);

        foreach ($fixture->oneToManyBidirectional as $element) {
            $this->assertInstanceOf(ManyToOneBidirectional::class, $element);
            $this->assertEquals($fixture, $element->manyToOneBidirectional);
        }
    }
}
