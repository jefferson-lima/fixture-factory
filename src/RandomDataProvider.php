<?php

namespace Jefferson\Lima;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Base;
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

    public function getDatetimeString(string $format): string
    {
        $randomDatetime = $this->faker->dateTime();
        return $randomDatetime->format($format);
    }

    public function getEmail(): string
    {
        return $this->faker->email;
    }

    public function getUuid(): string
    {
        return $this->faker->uuid;
    }

    public function getUrl(): string
    {
        return $this->faker->url;
    }

    public function getRegex(string $regex): string
    {
        return static::regexify($regex);
    }

    /**
     * @param array $elements
     * @return mixed|null
     */
    public function getElementOf(array $elements)
    {
        return $this->faker->randomElement($elements);
    }

    /**
     * This method was copied from fzaninotto/Faker v1.9.1 and should be replaced
     * when this dependency is upgraded.
     *
     * @param string $regex
     * @return string|string[]|null
     */
    private static function regexify($regex = '')
    {
        // ditch the anchors
        $regex = preg_replace('/^\/?\^?/', '', $regex);
        $regex = preg_replace('/\$?\/?$/', '', $regex);
        // All {2} become {2,2}
        $regex = preg_replace('/\{(\d+)\}/', '{\1,\1}', $regex);
        // Single-letter quantifiers (?, *, +) become bracket quantifiers ({0,1}, {0,rand}, {1, rand})
        $regex = preg_replace('/(?<!\\\)\?/', '{0,1}', $regex);
        $regex = preg_replace('/(?<!\\\)\*/', '{0,' . Base::randomDigitNotNull() . '}', $regex);
        $regex = preg_replace('/(?<!\\\)\+/', '{1,' . Base::randomDigitNotNull() . '}', $regex);
        // [12]{1,2} becomes [12] or [12][12]
        $regex = preg_replace_callback('/(\[[^\]]+\])\{(\d+),(\d+)\}/', function ($matches) {
            return str_repeat($matches[1], Base::randomElement(range($matches[2], $matches[3])));
        }, $regex);
        // (12|34){1,2} becomes (12|34) or (12|34)(12|34)
        $regex = preg_replace_callback('/(\([^\)]+\))\{(\d+),(\d+)\}/', function ($matches) {
            return str_repeat($matches[1], Base::randomElement(range($matches[2], $matches[3])));
        }, $regex);
        // A{1,2} becomes A or AA or \d{3} becomes \d\d\d
        $regex = preg_replace_callback('/(\\\?.)\{(\d+),(\d+)\}/', function ($matches) {
            return str_repeat($matches[1], Base::randomElement(range($matches[2], $matches[3])));
        }, $regex);
        // (this|that) becomes 'this' or 'that'
        $regex = preg_replace_callback('/\((.*?)\)/', function ($matches) {
            return Base::randomElement(explode('|', str_replace(array('(', ')'), '', $matches[1])));
        }, $regex);
        // All A-F inside of [] become ABCDEF
        $regex = preg_replace_callback('/\[([^\]]+)\]/', function ($matches) {
            return '[' . preg_replace_callback('/(\w|\d)\-(\w|\d)/', function ($range) {
                    return implode('', range($range[1], $range[2]));
                }, $matches[1]) . ']';
        }, $regex);
        // All [ABC] become B (or A or C)
        $regex = preg_replace_callback('/\[([^\]]+)\]/', function ($matches) {
            return Base::randomElement(str_split($matches[1]));
        }, $regex);
        // replace \d with number and \w with letter and . with ascii
        $regex = preg_replace_callback('/\\\w/', [Base::class, 'randomLetter'], $regex);
        $regex = preg_replace_callback('/\\\d/', [Base::class, 'randomDigit'], $regex);
        $regex = preg_replace_callback('/(?<!\\\)\./', [Base::class, 'randomLetter'], $regex);
        // remove remaining backslashes
        $regex = str_replace('\\', '', $regex);
        // phew
        return $regex;
    }
}
