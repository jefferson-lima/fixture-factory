<?php

namespace Jefferson\Lima\String;

use Faker\Factory;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;
use Symfony\Component\Validator\Constraints\Uuid;

class StringUuidHandler extends PropertyAnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $annotation = $property->getAnnotation(Uuid::class);

        if ($annotation) {
            $faker = Factory::create();
            return $faker->uuid;
        }

        return $this->handleNext($property, $value);
    }
}
