<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

class ManyToManyMappedBy
{
    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="ManyToManyInversedBy", mappedBy="manyToManyMappedBy")
     */
    public $manyToManyInversedBy;
}
