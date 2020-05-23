<?php

namespace Jefferson\Lima\ValueGenerator;

use Jefferson\Lima\RandomDataProvider;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

abstract class ValueGenerator
{
    /** @var RandomDataProvider */
    protected $randomDataProvider;

    public function __construct()
    {
        $this->randomDataProvider = new RandomDataProvider();
    }

    /**
     * @param DocTypedReflectionProperty $property
     * @return mixed
     */
    abstract public function generate(DocTypedReflectionProperty $property);
}