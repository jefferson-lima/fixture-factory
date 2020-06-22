<?php

namespace Jefferson\Lima\Test\ValueGenerator;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\OneToOne;
use Jefferson\Lima\FixtureFactoryException;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Test\TestObject\OneToManyUnidirectional;
use Jefferson\Lima\Test\TestObject\OneToOneA;
use Jefferson\Lima\Test\TestObject\OneToOneB;
use Jefferson\Lima\Test\TestObject\OneToOneC;
use Jefferson\Lima\Test\TestObject\TestObject;
use Jefferson\Lima\ValueGenerator\Object\ObjectValueGenerator;
use PHPUnit\Framework\TestCase;

class ObjectValueGeneratorTest extends TestCase
{
    /** @var ObjectValueGenerator */
    private $objectGenerator;

    /**
     * @var OneToOneB
     * @OneToOne(targetEntity="OneToOneB")
     */
    private $oneToOneWithoutInversedBy;

    /**
     * @var OneToOneB
     * @OneToOne(targetEntity="OneToOneB", inversedBy="invalidProperty")
     */
    private $oneToOneWithInvalidProperty;

    protected function setUp(): void
    {
        $this->objectGenerator = new ObjectValueGenerator();
    }

    public function testOneToOneInversedBy(): void
    {
        $initialObject = new OneToOneA();
        $property = new DocTypedReflectionProperty(OneToOneA::class, 'oneToOneBInversedBy');
        $object = $this->objectGenerator->generate($property, $initialObject);

        $this->assertInstanceOf(OneToOneB::class, $object);
        $this->assertEquals($initialObject, $object->oneToOneAMappedBy);
    }

    public function testOneToOneMappedBy(): void
    {
        $initialObject = new OneToOneA();
        $property = new DocTypedReflectionProperty(OneToOneA::class, 'oneToOneCMappedBy');
        $object = $this->objectGenerator->generate($property, $initialObject);

        $this->assertInstanceOf(OneToOneC::class, $object);
        $this->assertEquals($initialObject, $object->oneToOneAInversedBy);
    }

    public function testOneToOneWithInvalidProperty(): void
    {
        $this->expectException(FixtureFactoryException::class);
        $property = new DocTypedReflectionProperty(__CLASS__, 'oneToOneWithInvalidProperty');
        $this->objectGenerator->generate($property, new OneToOneA());
    }

    public function testOneToManyUnidirectional(): void
    {
        $initialObject = new OneToManyUnidirectional();
        $property = new DocTypedReflectionProperty(OneToManyUnidirectional::class, 'oneToManyUnidirectional');
        $collection = $this->objectGenerator->generate($property, $initialObject);

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(2, $collection);

        foreach ($collection as $element) {
            $this->assertInstanceOf(TestObject::class, $element);
        }
    }
}
