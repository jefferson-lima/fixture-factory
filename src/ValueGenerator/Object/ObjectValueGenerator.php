<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\Annotation\AnnotationHandler;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\ValueGenerator\ValueGenerator;

class ObjectValueGenerator extends ValueGenerator
{
    /** @var AnnotationHandler */
    private $handlerChain;

    public function __construct()
    {
        parent::__construct();
        $this->handlerChain = new OneToOneHandler();
        $this->handlerChain->setNext(new ManyToOneHandler());
    }

    /**
     * @inheritDoc
     */
    public function generate(DocTypedReflectionProperty $property, $object)
    {
        $generatedObject = $this->handlerChain->handle($property, null, $object);
        return $generatedObject ?? FixtureFactory::createFixture($property->getFqsen());
    }
}
