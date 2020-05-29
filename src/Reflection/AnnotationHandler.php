<?php

namespace Jefferson\Lima\Reflection;

use Faker\Factory;
use Faker\Generator;
use Jefferson\Lima\RandomDataProvider;

class AnnotationHandler
{
    /** @var  AnnotationHandler */
    private $nextHandler;

    /** @var RandomDataProvider */
    protected $randomDataProvider;

    /** @var callable */
    private $handler;

    /** @var string */
    private $annotationClass;

    public function __construct(callable $handler = null, string $annotationClass = null)
    {
        $this->handler = $handler;
        $this->annotationClass = $annotationClass;
        $this->faker = Factory::create();
        $this->randomDataProvider = new RandomDataProvider();
    }

    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $annotation = $property->getAnnotation($this->annotationClass);
        return $annotation ? call_user_func($this->handler) : $this->handleNext($property, $value);
    }

    public function setNext(AnnotationHandler $nextHandler): AnnotationHandler
    {
        $this->nextHandler = $nextHandler;
        return $this->nextHandler;
    }

    protected function handleNext(DocTypedReflectionProperty $property, $value)
    {
        return $this->nextHandler ? $this->nextHandler->handle($property, $value) : $value;
    }
}
