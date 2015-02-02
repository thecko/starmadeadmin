<?php

namespace Starmade\APIBundle\Model;

class Ship {

    public function __construct(
    $uniqueid
    , $name
    , $creatorid
    , $mass
    ) {
        $this->uniqueid = $uniqueid;
        $this->name = $name;
        $this->creatorid = $creatorid;
        $this->mass = $mass;
    }

    /**
     * @var int
     */
    public $uniqueid;

    /**
     * @var string
     */
    public $secret;

    /**
     * @var string The ship name
     */
    public $name;

    /**
     * @var string The ship creator id
     */
    public $creatorid;
    
    /**
     * @var double The ship's mass
     */
    public $mass;

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
        return $this->name;
    }

}
