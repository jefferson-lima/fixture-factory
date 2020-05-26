<?php

namespace Jefferson\Lima;

use Faker\Factory;
use Faker\Generator;
use Jefferson\Lima\Reflection\DocType;
use InvalidArgumentException;

class RandomDataProvider
{
    /** @var Generator */
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * @param $min int|float
     * @param $max int|float
     * @param $type string
     * @return int|float
     * @throws InvalidArgumentException
     */
    public function getRandomNumber($min, $max, $type)
    {
        if ($type !== DocType::INT && $type !== DocType::FLOAT) {
            throw new InvalidArgumentException("Invalid type: $type");
        }

        if (!is_numeric($min) || !is_numeric($max)) {
            throw new InvalidArgumentException("min and max should both be numeric");
        }

        if ($type === DocType::INT) {
            return $this->faker->numberBetween($min, $max);
        } else {
            return $this->faker->randomFloat(2, $min, $max);
        }
    }

    public function getPositiveNumber(string $type)
    {
        $max = $type === DocType::INT ? PHP_INT_MAX : PHP_FLOAT_MAX;
        return $this->getRandomNumber(1, $max, $type);
    }

    public function getNegativeNumber(string $type)
    {
        $min = $type === DocType::INT ? PHP_INT_MIN : PHP_FLOAT_MIN;
        return $this->getRandomNumber($min, -1, $type);
    }

    public function getDateString(): string
    {
        return $this->faker->date();
    }
}
