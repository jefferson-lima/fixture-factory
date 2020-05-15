<?php

namespace Jefferson\Lima;

use Doctrine\Common\Annotations\AnnotationReader;
use Faker\Factory;
use Faker\Provider\Lorem;
use ReflectionProperty;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class StringValueGenerator
{
    public function generate(ReflectionProperty $property)
    {
        $value = Lorem::word();

        $annotationReader = new AnnotationReader();
        $lengthAnnotation = $annotationReader->getPropertyAnnotation($property, Length::class);

        if ($lengthAnnotation) {
            $value = Lorem::text();
        }

        return $value;
    }
}
