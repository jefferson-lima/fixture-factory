<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

class ManyToOneBidirectional
{
    /**
     * @var OneToManyBidirectional
     * @ORM\ManyToOne(targetEntity="OneToManyBidirectional", inversedBy="oneToManyBidirectional")
     */
    public $manyToOneBidirectional;
}
