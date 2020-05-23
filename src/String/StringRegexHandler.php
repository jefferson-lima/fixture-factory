<?php

namespace Jefferson\Lima\String;

use Faker\Factory;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;
use Symfony\Component\Validator\Constraints\Regex;

class StringRegexHandler extends PropertyAnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $regexAnnotation = $property->getAnnotation(Regex::class);

        if ($regexAnnotation) {
            $pattern = $regexAnnotation->pattern;
            return $this->faker->regexify($pattern);
        }

        return $this->handleNext($property, $value);
    }
}
