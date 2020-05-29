<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\AnnotationHandler;
use Symfony\Component\Validator\Constraints\Regex;

class StringRegexHandler extends AnnotationHandler
{
    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $regexAnnotation = $property->getAnnotation(Regex::class);

        if ($regexAnnotation) {
            $pattern = $regexAnnotation->pattern;
            return $this->randomDataProvider->getRegex($pattern);
        }

        return $this->handleNext($property, $value);
    }
}
