<?php

namespace Starmade\APIBundle\Model;

class FactionCollection
{
    /**
     * @var Faction[]
     */
    public $factions;

    /**
     * @var integer
     */
    public $offset;

    /**
     * @var integer
     */
    public $limit;

    /**
     * @param Faction[]  $factions
     * @param integer $offset
     * @param integer $limit
     */
    public function __construct($factions = array(), $offset = null, $limit = null)
    {
        $this->factions = $factions;
        $this->offset = $offset;
        $this->limit = $limit;
    }
}
