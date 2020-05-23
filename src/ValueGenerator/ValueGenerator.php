<?php

namespace Jefferson\Lima\ValueGenerator;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

interface ValueGenerator
{
    /**
     * @param DocTypedReflectionProperty $property
     * @return mixed
     */
    public function generate(DocTypedReflectionProperty $property);
}