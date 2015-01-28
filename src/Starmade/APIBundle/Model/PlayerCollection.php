<?php

namespace Starmade\APIBundle\Model;

class PlayerCollection
{
    /**
     * @var Player[]
     */
    public $players;

    /**
     * @var integer
     */
    public $offset;

    /**
     * @var integer
     */
    public $limit;

    /**
     * @param Player[]  $players
     * @param integer $offset
     * @param integer $limit
     */
    public function __construct($players = array(), $offset = null, $limit = null)
    {
        $this->players = $players;
        $this->offset = $offset;
        $this->limit = $limit;
    }
}
