<?php

namespace Starmade\APIBundle\Model;

class BlueprintCollection
{
    /**
     * @var Blueprint[]
     */
    public $blueprints;

    /**
     * @var integer
     */
    public $offset;

    /**
     * @var integer
     */
    public $limit;

    /**
     * @param Blueprint[]  $blueprints
     * @param integer $offset
     * @param integer $limit
     */
    public function __construct($blueprints = array(), $offset = null, $limit = null)
    {
        $this->blueprints = $blueprints;
        $this->offset = $offset;
        $this->limit = $limit;
    }
}
