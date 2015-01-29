<?php

namespace Starmade\APIBundle\Model;

class Playerconnection {

    public function __construct(
    $playername
    , $stamp
    , $ip
    ) {
        $this->playername = $playername;
        $this->stamp = \DateTime::createFromFormat("U" , $stamp);
        $this->ip = $ip;
    }

    /**
     * @var string
     */
    public $playername;
    
    /**
     * @var datetime
     */
    public $stamp;
    
    /**
     * @var string
     */
    public $ip;

    /**
     * @var string
     */
    public $secret;

    /**
     * @var string The original version
     */
    public $version = 1;

    /**
     * @var string This version will be used since 1.1
     */
    public $new_version = 1.1;
    
    /**
     * String representation for a ship
     *
     * @return string
     */
    public function __toString() {
        return $this->playername . " " . $this->stamp->format("d/m/Y");
    }

}
