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
     * @var integer
     */
    public $count;

    /**
     * @param Faction[]  $factions
     * @param integer $offset
     * @param integer $limit
     * @param integer $count
     */
    public function __construct($factions = array(), $offset = null, $limit = null, $count = null)
    {
        $this->factions = $factions;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->count = $count;
    }
}
