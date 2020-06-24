<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\ORM\Mapping as ORM;

class ManyToOneBidirectional
{
    /**
     * @var OneToManyBidirectional
     * @ORM\ManyToOne(targetEntity="OneToManyBidirectional", inversedBy="manyToOneBidirectional")
     */
    public $oneToManyBidirectional;
}
