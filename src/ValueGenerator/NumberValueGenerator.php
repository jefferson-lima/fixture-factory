<?php

namespace Jefferson\Lima\ValueGenerator;

use InvalidArgumentException;
use Jefferson\Lima\Reflection\DocType;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

class NumberValueGenerator extends ValueGenerator
{
    /** @var string */
    private $type;

    public function __construct(string $type)
    {
        parent::__construct();

        if ($type !== DocType::INT && $type !== DocType::FLOAT) {
            throw new InvalidArgumentException("Invalid number type: $type");
        }

        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function generate(DocTypedReflectionProperty $property)
    {
        return $this->randomDataProvider->getPositiveNumber($this->type);
    }
}
