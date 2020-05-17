<?php

namespace Jefferson\Lima;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Faker\Provider\Lorem;
use ReflectionProperty;
use Symfony\Component\Validator\Constraints\Length;

class StringValueGenerator
{
    /**
     * @param ReflectionProperty $property
     * @return string
     * @throws AnnotationException
     */
    public function generate(ReflectionProperty $property): string
    {
        $value = Lorem::word();
        $value = $this->applyLengthAnnotation($property, $value);

        return $value;
    }

    /**
     * @param ReflectionProperty $property
     * @param string $value
     * @return string
     * @throws AnnotationException
     */
    public function applyLengthAnnotation(ReflectionProperty $property, string $value): string
    {
        $annotationReader = new AnnotationReader();
        $lengthAnnotation = $annotationReader->getPropertyAnnotation($property, Length::class);

        if ($lengthAnnotation) {
            if ($lengthAnnotation->min) {
                $value = $this->generateMinLengthStr($value, $lengthAnnotation->min);
            }

            if ($lengthAnnotation->max) {
                $value = $this->generateMaxLengthStr($value, $lengthAnnotation->max);
            }
        }
        return $value;
    }

    private function generateMinLengthStr(string $text, int $minLength): string
    {
        while (strlen($text) < $minLength) {
            $text .= ' ' . Lorem::word();
        }

        return $text;
    }

    private function generateMaxLengthStr(string $text, int $maxLength): string
    {
        if (strlen($text) > $maxLength) {
            $text = substr($text, 0, $maxLength);
        }

        return $text;
    }
}
