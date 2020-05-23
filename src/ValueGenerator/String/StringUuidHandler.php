<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;
use Symfony\Component\Validator\Constraints\Uuid;

class StringUuidHandler extends PropertyAnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $annotation = $property->getAnnotation(Uuid::class);
        return $annotation ? $this->faker->uuid : $this->handleNext($property, $value);
    }
}
