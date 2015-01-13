<?php

namespace Starmade\APIBundle\Model;

class ShopCollection
{
    /**
     * @var Shop[]
     */
    public $shops;

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
        $this->shops = $shops;
        $this->offset = $offset;
        $this->limit = $limit;
    }
}
