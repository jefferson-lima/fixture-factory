<?php

namespace Jefferson\Lima\Test\Annotation;

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Jefferson\Lima\Annotation\AssociationAnnotation;
use Jefferson\Lima\FixtureFactoryException;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\ContextFactory;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Jefferson\Lima\Test\TestObject\TestObject;

class AssociationAnnotationTest extends TestCase
{
    /** @var Context */
    private static $context;

    /**
     * @OneToOne(targetEntity="TestObject")
     */
    private $association;

    /**
     * @OneToOne(targetEntity="TestObject", inversedBy="objAttr")
     */
    private $associationInversedBy;

    /**
     * @OneToOne(targetEntity="TestObject", mappedBy="objAttr")
     */
    private $associationMappedBy;

    /**
     * @OneToOne(targetEntity="TestObject", mappedBy="invalidProperty")
     */
    private $associationWithInvalidProperty;

    /**
     * @OneToOne(targetEntity="Jefferson\Lima\Test\TestObject\TestObject", mappedBy="objAttr")
     */
    private $fullyQualifiedNameTargetEntity;

    public static function setUpBeforeClass(): void
    {
        $contextFactory = new ContextFactory();
        static::$context = $contextFactory->createFromReflector(new ReflectionClass(__CLASS__));
    }

    public function testConstructWithInvalidAnnotation(): void
    {
        $annotation = new Id();

        $this->expectException(FixtureFactoryException::class);
        new AssociationAnnotation($annotation, static::$context);
    }

    public function testGetTargetEntity(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'association');
        $annotation = $property->getAnnotation(OneToOne::class);
        $associationAnnotation = new AssociationAnnotation($annotation, static::$context);
        $this->assertEquals(TestObject::class, $associationAnnotation->getTargetEntity());
    }

    public function testGetTargetPropertyInversedBy(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'associationInversedBy');
        $annotation = $property->getAnnotation(OneToOne::class);
        $associationAnnotation = new AssociationAnnotation($annotation, static::$context);

        $targetProperty = $associationAnnotation->getTargetProperty();

        $this->assertInstanceOf(DocTypedReflectionProperty::class, $property);
        $this->assertEquals($annotation->inversedBy, $targetProperty->getName());
    }

    public function testGetTargetPropertyMappedBy(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'associationMappedBy');
        $annotation = $property->getAnnotation(OneToOne::class);
        $associationAnnotation = new AssociationAnnotation($annotation, static::$context);

        $targetProperty = $associationAnnotation->getTargetProperty();

        $this->assertInstanceOf(DocTypedReflectionProperty::class, $property);
        $this->assertEquals($annotation->mappedBy, $targetProperty->getName());
    }

    public function testGetTargetPropertyWithInvalidProperty(): void
    {
        $this->expectException(FixtureFactoryException::class);
        $property = new DocTypedReflectionProperty(__CLASS__, 'associationWithInvalidProperty');
        $annotation = $property->getAnnotation(OneToOne::class);
        $associationAnnotation = new AssociationAnnotation($annotation, static::$context);
        $associationAnnotation->getTargetProperty();
    }

    public function testGetTargetPropertyWithFullyQualifiedNameTargetEntity(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'fullyQualifiedNameTargetEntity');
        $annotation = $property->getAnnotation(OneToOne::class);
        $associationAnnotation = new AssociationAnnotation($annotation, static::$context);

        $targetProperty = $associationAnnotation->getTargetProperty();

        $this->assertInstanceOf(DocTypedReflectionProperty::class, $property);
        $this->assertEquals($annotation->mappedBy, $targetProperty->getName());
    }
}
