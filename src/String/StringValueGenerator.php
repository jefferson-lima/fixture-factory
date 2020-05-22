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
        $this->handlerChain = new StringEmailHandler();
        $this->handlerChain->setNext(new StringMinLengthHandler())
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
