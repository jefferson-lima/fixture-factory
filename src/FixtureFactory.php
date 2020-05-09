<?php

namespace Jefferson\Lima;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use Faker\Factory;
use Faker\Provider\Lorem;
use ReflectionClass;
use ReflectionProperty;

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

        $reflectionClass = new ReflectionClass($class);
        $docBlockFactory = DocBlockFactory::createInstance();

        foreach ($reflectionClass->getProperties() as $property) {
            $propertyFixture = self::createFixtureForProperty($property, $docBlockFactory);
            $property->setAccessible(true);
            $property->setValue($fixtureObject, $propertyFixture);
        }

        return $fixtureObject;
    }

    /**
     * @param ReflectionProperty $property
     * @param DocBlockFactory $docBlockFactory
     * @return string|null
     */
    private static function createFixtureForProperty(
        ReflectionProperty $property,
        DocBlockFactory $docBlockFactory
    ) {
        $faker = Factory::create();
        $fixture = null;

        $varTagType = static::getPropertyType($property, $docBlockFactory);

        if ($varTagType instanceof String_) {
            $fixture = Lorem::word();
        }

        if ($varTagType instanceof Integer) {
            $fixture = $faker->randomNumber();
        }

        if ($varTagType instanceof Boolean) {
            $fixture = false;
        }

        if ($varTagType instanceof Float_) {
            $fixture = $faker->randomFloat();
        }

        if ($varTagType instanceof Array_) {
            $fixture = [];
        }

        return $fixture;
    }

    private static function getPropertyType(
        ReflectionProperty $property,
        DocBlockFactory $docBlockFactory
    ): ?Type
    {
        $varTagType = null;
        $docComment = $property->getDocComment();

        if ($docComment) {
            $docBlock = $docBlockFactory->create($docComment);
            $varTags = $docBlock->getTagsByName('var');

            if (count($varTags) > 0) {
                $varTag = $varTags[0];

                if ($varTag instanceof Var_) {
                    $varTagType = $varTag->getType();

                    if ($varTagType instanceof Compound) {
                        $varTagType = $varTagType->get(0);
                    }
                }
            }
        }

        return $varTagType;
    }
}
