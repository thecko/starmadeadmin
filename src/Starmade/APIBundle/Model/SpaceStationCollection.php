<?php

namespace Starmade\APIBundle\Model;

class SpaceStationCollection
{
    /**
     * @var SpaceStation[]
     */
    public $spacestations;

    /**
     * @var integer
     */
    public $offset;

    /**
     * @var integer
     */
    public $limit;

    /**
     * @param Ship[]  $shops
     * @param integer $offset
     * @param integer $limit
     */
    public function __construct($shops = array(), $offset = null, $limit = null)
    {
        $this->spacestations = $shops;
        $this->offset = $offset;
        $this->limit = $limit;
    }
}