<?php

namespace Starmade\APIBundle\Model;

class EntityCollection
{
    /**
     * @var Object[]
     */
    public $data;

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
     * @param Object[]  $data
     * @param integer $offset
     * @param integer $limit
     */
    public function __construct($data = array(), $offset = null, $limit = null, $count)
    {
        $this->data = $data;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->count = $count;
    }
}
