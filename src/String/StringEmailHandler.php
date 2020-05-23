<?php

namespace Jefferson\Lima\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;
use Symfony\Component\Validator\Constraints\Email;

class StringEmailHandler extends PropertyAnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $emailAnnotation = $property->getAnnotation(Email::class);
        return $emailAnnotation ? $this->faker->email : $this->handleNext($property, $value);
    }
}
