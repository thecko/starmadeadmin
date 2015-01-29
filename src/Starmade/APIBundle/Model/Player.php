<?php

namespace Starmade\APIBundle\Model;

use Starmade\APIBundle\Model\Sector;

class Player {

    public function __construct(
    $uniqueid
    , $name
    , $credits
    , $sector
    , $faction
    , $connections
    ) {
        $this->uniqueid = $uniqueid;
        $this->name = $name;
        $this->credits = $credits;
        $this->sector = $sector;
        $this->faction = $faction;
        $this->connections = $connections;
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
     * @var string The player's name
     */
    public $name;
    
    /**
     * @var int The player's credits
     */
    public $credits;
    
    /**
     * @var Sector The player's actual sector
     */
    public $sector;
    
    /**
     * @var int The player's faction
     */
    public $faction;
    
    /**
     * @var PlayerConnection[] The player's connection history
     */
    public $connections;

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
