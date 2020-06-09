<?php

namespace Jefferson\Lima\Test\TestObject;

use Doctrine\ORM\Mapping\OneToOne;

class OneToOneB
{
    /**
     * @var OneToOneA
     * @OneToOne(targetEntity="OneToOneA", mappedBy="oneToOneOwned")
     */
    private $oneToOneA;

    /**
     * @return mixed
     */
    public function getOneToOneA()
    {
        return $this->oneToOneA;
    }

    /**
     * @param mixed $oneToOneA
     */
    public function setOneToOneA($oneToOneA): void
    {
        $this->oneToOneA = $oneToOneA;
    }
}