<?php

namespace Jefferson\Lima\ValueGenerator\String;

use Faker\Provider\Lorem;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\Reflection\AnnotationHandler;
use Jefferson\Lima\ValueGenerator\ValueGenerator;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Uuid;

class StringValueGenerator extends ValueGenerator
{
    /** @var AnnotationHandler */
    private $handlerChain;

    public function __construct()
    {
        parent::__construct();

        $this->handlerChain = new AnnotationHandler([$this->randomDataProvider, 'getUuid'], Uuid::class);
        $this->handlerChain
             ->setNext(new StringRegexHandler())
             ->setNext(new AnnotationHandler([$this->randomDataProvider, 'getEmail'], Email::class))
             ->setNext(new AnnotationHandler([$this->randomDataProvider, 'getUrl'], Url::class))
             ->setNext(new AnnotationHandler([$this->randomDataProvider, 'getDateString'], Date::class))
             ->setNext(new StringDatetimeHandler())
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
