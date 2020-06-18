<?php

namespace Jefferson\Lima\Annotation;

use Jefferson\Lima\FixtureFactoryException;
use Jefferson\Lima\RandomDataProvider;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

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
        $this->randomDataProvider = new RandomDataProvider();
    }

    /**
     * @param DocTypedReflectionProperty $property
     * @param $value
     * @param $object
     * @throws FixtureFactoryException
     * @return mixed
     */
    public function handle(DocTypedReflectionProperty $property, $value, $object)
    {
        $annotation = $property->getAnnotation($this->annotationClass);
        return $annotation ? call_user_func($this->handler) : $this->handleNext($property, $value, $object);
    }

    public function setNext(AnnotationHandler $nextHandler): AnnotationHandler
    {
        $this->nextHandler = $nextHandler;
        return $this->nextHandler;
    }

    protected function handleNext(DocTypedReflectionProperty $property, $value, $object)
    {
        return $this->nextHandler ? $this->nextHandler->handle($property, $value, $object) : $value;
    }
}
