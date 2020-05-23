<?php

namespace Jefferson\Lima;

use Jefferson\Lima\Reflection\DocType;
use Jefferson\Lima\Reflection\DocTypedReflectionClass;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Faker\Factory;
use Jefferson\Lima\ValueGenerator\NumberValueGenerator;
use Jefferson\Lima\ValueGenerator\String\StringValueGenerator;

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
        $faker = Factory::create();
        $varTagType = $property->getVarType();

        switch ($varTagType) {
            case null:
                return null;
            case DocType::STRING:
                $stringGenerator = new StringValueGenerator();
                return $stringGenerator->generate($property);
            case DocType::INT:
                $intGenerator = new NumberValueGenerator(DocType::INT);
                return $intGenerator->generate($property);
            case DocType::BOOL:
                return false;
            case DocType::FLOAT:
                $floatGenerator = new NumberValueGenerator(DocType::FLOAT);
                return $floatGenerator->generate($property);
            case DocType::ARRAY:
                return [];
            default:
                throw new FixtureFactoryException("Unknown type: $varTagType");
        }
    }
}
