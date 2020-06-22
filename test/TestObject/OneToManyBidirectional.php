<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

class OneToManyBidirectional
{
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ManyToOneBidirectional", mappedBy="manyToOneBidirectional")
     */
    public $oneToManyBidirectional;
}
