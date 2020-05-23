<?php

namespace Jefferson\Lima\Reflection;

use Faker\Factory;
use Faker\Generator;

abstract class PropertyAnnotationHandler
{
    /** @var  PropertyAnnotationHandler */
    private $nextHandler;

    /** @var Generator */
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    abstract public function handle(DocTypedReflectionProperty $property, $value);

    public function setNext(PropertyAnnotationHandler $nextHandler): PropertyAnnotationHandler
    {
        $this->nextHandler = $nextHandler;
        return $this->nextHandler;
    }

    public function handleNext(DocTypedReflectionProperty $property, $value)
    {
        return $this->nextHandler ? $this->nextHandler->handle($property, $value) : $value;
    }
}
