<?php

namespace Jefferson\Lima\String;

use Faker\Factory;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;
use Symfony\Component\Validator\Constraints\Email;

class StringEmailHandler extends PropertyAnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $emailAnnotation = $property->getAnnotation(Email::class);
        $faker = Factory::create();
        return $emailAnnotation ? $faker->email : $this->handleNext($property, $value);
    }
}
