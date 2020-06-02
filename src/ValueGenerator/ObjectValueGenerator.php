<?php

namespace Jefferson\Lima\ValueGenerator;

use Jefferson\Lima\FixtureFactory;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

class ObjectValueGenerator extends ValueGenerator
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function generate(DocTypedReflectionProperty $property)
    {
        return FixtureFactory::createFixture($property->getFqsen());
    }
}
