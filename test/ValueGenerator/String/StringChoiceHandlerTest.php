<?php

namespace Jefferson\Lima\Test\ValueGenerator\String;

use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\ValueGenerator\String\StringChoiceHandler;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Symfony\Component\Validator\Constraints as Assert;

class StringChoiceHandlerTest extends TestCase
{
    public CONST CHOICES = ['a', 'b', 'c'];

    /** @var StringChoiceHandler */
    private $handler;

    /**
     * @var string
     * @Assert\Choice(choices={"a", "b", "c"})
     */
    private $choiceWithArray;

    /**
     * @var string
     * @Assert\Choice(choices=StringChoiceHandlerTest::CHOICES)
     */
    private $choiceWithArrayConstant;

    /**
     * @var string
     * @Assert\Choice(callback={StringChoiceHandlerTest::class, "getChoices"})
     */
    private $choiceWithFunctionCallable;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new StringChoiceHandler();
    }

    public function choiceDataProvider(): array
    {
        return [
            'choiceWithArray' => ['choiceWithArray', ['a', 'b', 'c']],
            'choiceWithArrayConstant' => ['choiceWithArrayConstant', static::CHOICES],
        ];
    }

    /**
     * @dataProvider choiceDataProvider
     * @param string $property
     * @param array $choices
     * @throws ReflectionException
     */
    public function testChoice(string $property, array $choices): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, $property);
        $value = $this->handler->handle($property, '');
        $this->assertContains($value, $choices);
    }

    public function testChoiceWithFunctionCallable(): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, 'choiceWithFunctionCallable');
        $value = $this->handler->handle($property, '');
        $this->assertContains($value, static::getChoices());
    }

    public static function getChoices(): array
    {
        return static::CHOICES;
    }
}
