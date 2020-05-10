<?php

namespace Jefferson\Lima\Test;

use Symfony\Component\Validator\Constraints as Assert;

class NotBlankTestObject
{

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $notBlankStringAttr;

    /**
     * @var bool
     * @Assert\NotBlank
     */
    private $notBlankBoolAttr;

    /**
     * @return string
     */
    public function getNotBlankStringAttr(): string
    {
        return $this->notBlankStringAttr;
    }

    /**
     * @return bool
     */
    public function isNotBlankBoolAttr(): bool
    {
        return $this->notBlankBoolAttr;
    }
}
