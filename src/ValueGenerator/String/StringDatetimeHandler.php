<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;
use Symfony\Component\Validator\Constraints\DateTime;

class StringDatetimeHandler extends PropertyAnnotationHandler
{
    public const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function handle(DocTypedReflectionProperty $property, $value)
    {
        $annotation = $property->getAnnotation(DateTime::class);

        if ($annotation) {
            $format = $annotation->format ?? static::DEFAULT_DATETIME_FORMAT;
            return $this->randomDataProvider->getDatetimeString($format);
        }

        return $this->handleNext($property, $value);
    }
}
