<?php

namespace Jefferson\Lima\Test\ValueGenerator\String;

use DateTime;
use Jefferson\Lima\Reflection\DocTypedReflectionProperty;
use Jefferson\Lima\ValueGenerator\String\StringDatetimeHandler;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Validator\Constraints as Assert;

class StringDatetimeHandlerTest extends TestCase
{
    /** @var StringDatetimeHandler */
    private $handler;

    /**
     * @var string
     * @Assert\DateTime()
     */
    private $datetimeWithoutFormat;

    /**
     * @var string
     * @Assert\DateTime(format="d/m/Y")
     */
    private $datetimeWithFormat;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new StringDatetimeHandler();
    }

    public function datetimeDataProvider(): array
    {
        return [
            'datetimeWithoutFormat' => ['datetimeWithoutFormat', StringDatetimeHandler::DEFAULT_DATETIME_FORMAT],
            'datetimeWithFormat' => ['datetimeWithFormat', 'd/m/Y']
        ];
    }

    /**
     * @dataProvider datetimeDataProvider
     * @param string $property
     * @param $format
     * @throws \ReflectionException
     */
    public function testDatetimeWithoutFormat(string $property, string $format): void
    {
        $property = new DocTypedReflectionProperty(__CLASS__, $property) ;
        $initialValue = 'abcdef';

        $value = $this->handler->handle($property, $initialValue, new stdClass());

        $this->assertIsString($value);
        $this->assertNotFalse(DateTime::createFromFormat($format, $value));
    }
}
