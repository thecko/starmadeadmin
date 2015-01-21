<?php

namespace Starmade\APIBundle\Model;

class ServerCollection
{
    /**
     * @var Server[]
     */
    public $servers;

    /**
     * @var integer
     */
    public $offset;

    /**
     * @var integer
     */
    public $limit;

    /**
     * @param Server[]  $servers
     * @param integer $offset
     * @param integer $limit
     */
    public function __construct($servers = array(), $offset = null, $limit = null)
    {
        $this->servers = $servers;
        $this->offset = $offset;
        $this->limit = $limit;
    }
}
