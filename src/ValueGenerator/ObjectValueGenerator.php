<?php

namespace Jefferson\Lima\ValueGenerator;

use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\ContextFactory;

class ObjectValueGenerator extends ValueGenerator
{
    /** @var FqsenResolver */
    private $fqsenResolver;

    /** @var ContextFactory */
    private $contextFactory;

    public function __construct()
    {
        parent::__construct();
        $this->fqsenResolver = new FqsenResolver();
        $this->contextFactory = new ContextFactory();
    }

    /**
     * @inheritDoc
     */
    public function generate(DocTypedReflectionProperty $property)
    {
        $fqsen = $property->getVarType()->getFqsen()->getName();

        $context = $this->contextFactory->createFromReflector($property);
        $type = $this->fqsenResolver->resolve($fqsen, $context);

        return FixtureFactory::createFixture($type->__toString());
    }
}
