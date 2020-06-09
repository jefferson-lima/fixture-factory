<?php

namespace Jefferson\Lima\ValueGenerator\Object;

use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\Reflection\AnnotationHandler;
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
