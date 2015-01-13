<?php

namespace Starmade\APIBundle\Model;

class Shop {

    public function __construct(
    $uniqueid
    , $name
    , $creatorid
    ) {
        $this->uniqueid = $uniqueid;
        $this->name = $name;
        $this->creatorid = $creatorid;
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
