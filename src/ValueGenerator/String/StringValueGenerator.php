<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Faker\Provider\Lorem;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\PropertyAnnotationHandler;
use Jefferson\Lima\ValueGenerator\ValueGenerator;

class StringValueGenerator extends ValueGenerator
{
    /** @var PropertyAnnotationHandler */
    private $handlerChain;

    public function __construct()
    {
        parent::__construct();

        $this->handlerChain = new StringUuidHandler();
        $this->handlerChain->setNext(new StringRegexHandler())
                           ->setNext(new StringEmailHandler())
                           ->setNext(new StringUrlHandler())
                           ->setNext(new StringMinLengthHandler())
                           ->setNext(new StringMaxLengthHandler());
    }

    /**
     * @inheritDoc
     */
    public function generate(DocTypedReflectionProperty $property)
    {
        return $this->handlerChain->handle($property, Lorem::word());
    }
}
