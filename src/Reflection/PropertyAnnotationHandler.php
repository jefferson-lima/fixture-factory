<?php

namespace Jefferson\Lima\Reflection;

abstract class PropertyAnnotationHandler
{
    /** @var  PropertyAnnotationHandler */
    private $nextHandler;

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
