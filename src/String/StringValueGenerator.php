<?php

namespace Jefferson\Lima\String;

use Faker\Provider\Lorem;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;

class StringValueGenerator
{
    /** @var PropertyAnnotationHandler */
    private $handlerChain;

    public function __construct()
    {
        $this->handlerChain = new StringRegexHandler();
        $this->handlerChain->setNext(new StringEmailHandler())
                           ->setNext(new StringMinLengthHandler())
                           ->setNext(new StringMaxLengthHandler());
    }

    /**
     * @param DocTypedReflectionProperty $property
     * @return string
     */
    public function generate(DocTypedReflectionProperty $property): string
    {
        return $this->handlerChain->handle($property, Lorem::word());
    }
}
