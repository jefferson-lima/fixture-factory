<?php

namespace Jefferson\Lima;

use Jefferson\Lima\Reflection\DocTypedReflectionClass;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\ValueGenerator\BooleanValueGenerator;
use Jefferson\Lima\ValueGenerator\NumberValueGenerator;
use Jefferson\Lima\ValueGenerator\ObjectValueGenerator;
use Jefferson\Lima\ValueGenerator\String\StringValueGenerator;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\String_;
use phpDocumentor\Reflection\Types\Integer;

class FixtureFactory
{
    /**
     * @param string $class
     * @return mixed
     * @throws FixtureFactoryException
     */
    public static function createFixture(string $class)
    {
        if (!class_exists($class)) {
            throw new FixtureFactoryException("The class $class was not defined");
        }

        $fixtureObject = new $class();

        $reflectionClass = new DocTypedReflectionClass($class);

        foreach ($reflectionClass->getDocProperties() as $property) {
            $propertyFixture = self::createFixtureForProperty($property);
            $property->setValue($fixtureObject, $propertyFixture);
        }

        return $fixtureObject;
    }

    /**
     * @param DocTypedReflectionProperty $property
     * @return mixed
     */
    private static function createFixtureForProperty(DocTypedReflectionProperty $property)
    {
        $varTagType = $property->getVarType();

        if ($varTagType === null) {
            return null;
        }

        switch (get_class($varTagType)) {
            case String_::class:
                $stringGenerator = new StringValueGenerator();
                return $stringGenerator->generate($property);
            case Integer::class:
                $intGenerator = new NumberValueGenerator($varTagType->__toString());
                return $intGenerator->generate($property);
            case Boolean::class:
                $booleanGenerator = new BooleanValueGenerator();
                return $booleanGenerator->generate($property);
            case Float_::class:
                $floatGenerator = new NumberValueGenerator($varTagType->__toString());
                return $floatGenerator->generate($property);
            case Array_::class:
                return [];
            case Object_::class:
                $objectGenerator = new ObjectValueGenerator();
                return $objectGenerator->generate($property);
            default:
                throw new FixtureFactoryException("Unknown type: {$varTagType->__toString()}");
        }
    }
}
