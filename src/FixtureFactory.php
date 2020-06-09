<?php

namespace Jefferson\Lima;

use Doctrine\ORM\Mapping\OneToOne;
use Jefferson\Lima\Reflection\DocTypedReflectionClass;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\ValueGenerator\BooleanValueGenerator;
use Jefferson\Lima\ValueGenerator\NumberValueGenerator;
use Jefferson\Lima\ValueGenerator\Object\ObjectValueGenerator;
use Jefferson\Lima\ValueGenerator\String\StringValueGenerator;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\String_;
use phpDocumentor\Reflection\Types\Integer;
use ReflectionException;

class FixtureFactory
{
    /**
     * @param string $class
     * @param array $overriddenAttrs
     * @return mixed
     * @throws ReflectionException
     */
    public static function createFixture(string $class, array $overriddenAttrs = [])
    {
        if (!class_exists($class)) {
            throw new FixtureFactoryException("The class $class was not defined");
        }

        $fixtureObject = new $class();

        $reflectionClass = new DocTypedReflectionClass($class);
        static::checkForCircularReference($reflectionClass, $overriddenAttrs);

        foreach ($reflectionClass->getDocProperties() as $property) {
            if (array_key_exists($property->getName(), $overriddenAttrs)) {
                $propertyValue = $overriddenAttrs[$property->getName()];
            } else {
                $propertyValue = self::createFixtureForProperty($property, $fixtureObject);
            }

            $property->setValue($fixtureObject, $propertyValue);
        }

        return $fixtureObject;
    }

    /**
     * @param DocTypedReflectionProperty $property
     * @return mixed
     */
    private static function createFixtureForProperty(DocTypedReflectionProperty $property, $fixtureObject)
    {
        $varTagType = $property->getVarType();

        if ($varTagType === null) {
            return null;
        }

        switch (get_class($varTagType)) {
            case String_::class:
                $stringGenerator = new StringValueGenerator();
                return $stringGenerator->generate($property, $fixtureObject);
            case Integer::class:
                $intGenerator = new NumberValueGenerator($varTagType->__toString());
                return $intGenerator->generate($property, $fixtureObject);
            case Boolean::class:
                $booleanGenerator = new BooleanValueGenerator();
                return $booleanGenerator->generate($property, $fixtureObject);
            case Float_::class:
                $floatGenerator = new NumberValueGenerator($varTagType->__toString());
                return $floatGenerator->generate($property, $fixtureObject);
            case Array_::class:
                return [];
            case Object_::class:
                $objectGenerator = new ObjectValueGenerator();
                return $objectGenerator->generate($property, $fixtureObject);
            default:
                throw new FixtureFactoryException("Unknown type: {$varTagType->__toString()}");
        }
    }

    /**
     * @throws FixtureFactoryException
     * @throws ReflectionException
     */
    private static function checkForCircularReference(DocTypedReflectionClass $class, array $overriddenAttrs): void
    {
        $visitedClasses = [];
        $stack = [$class->getName()];

        while (!empty($stack)) {
            $currentClass = array_pop($stack);
            $visitedClasses[] = $currentClass;
            $reflectionClass = new DocTypedReflectionClass($currentClass);

            $objectProperties = $reflectionClass->getObjectProperties();

            $objectProperties = array_filter(
                $objectProperties,
                static function (DocTypedReflectionProperty $property) use ($overriddenAttrs) {
                    $oneToOne = $property->getAnnotation(OneToOne::class);

                    return !array_key_exists($property->getName(), $overriddenAttrs) &&
                        $oneToOne === null;
                }
            );

            $objectsClassNames = array_map(
                static function (DocTypedReflectionProperty $property) {
                    return $property->getFqsen();
                },
                $objectProperties
            );

            foreach ($objectsClassNames as $objectsClassName) {
                if (in_array($objectsClassName, $visitedClasses, true)) {
                    throw new FixtureFactoryException("Circular reference on class $objectsClassName");
                }

                $stack[] = $objectsClassName;
            }
        }
    }
}
