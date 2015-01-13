<?php

namespace Starmade\APIBundle\Model;

class Planet {

    public function __construct(
    $uniqueid
    ) {
        $this->uniqueid = $uniqueid;
    }

    /**
     * @var string
     */
    public $uniqueid;
    
    /**
     * @var int
     */
    public $factionid;

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
        return $this->uniqueid;
    }

}
