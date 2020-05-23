<?php

namespace Jefferson\Lima\ValueGenerator;

use Faker\Factory;
use InvalidArgumentException;
use Jefferson\Lima\Reflection\DocType;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;

class NumberValueGenerator implements ValueGenerator
{
    /** @var string */
    private $type;

    public function __construct(string $type)
    {
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
        $faker = Factory::create();

        if ($this->type === DocType::INT) {
            return $faker->randomNumber();
        } else {
            return $faker->randomFloat();
        }
    }
}
