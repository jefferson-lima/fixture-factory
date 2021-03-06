<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class OneToManyBidirectional
{
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ManyToOneBidirectional", mappedBy="oneToManyBidirectional")
     */
    public $manyToOneBidirectional;
}
