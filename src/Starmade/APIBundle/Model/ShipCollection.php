<?php

namespace Starmade\APIBundle\Model;

class ShipCollection {

    /**
     * @var Ship[]
     */
    public $ships;

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
    public $total;

    /**
     * @param Ship[]  $ships
     * @param integer $offset
     * @param integer $limit
     */
    public function __construct($ships = array(), $offset = null, $limit = null, $total = null) {
        $this->ships = $ships;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->total = $total;
    }

}
