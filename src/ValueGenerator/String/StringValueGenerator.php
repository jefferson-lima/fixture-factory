<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Faker\Provider\Lorem;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;

class StringValueGenerator
{
    /** @var PropertyAnnotationHandler */
    private $handlerChain;

    public function __construct()
    {
        $this->handlerChain = new StringUuidHandler();
        $this->handlerChain->setNext(new StringRegexHandler())
                           ->setNext(new StringEmailHandler())
                           ->setNext(new StringUrlHandler())
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
