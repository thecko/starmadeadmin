<?php

namespace Starmade\APIBundle\Model;

class SpaceStation {

    public function __construct(
    $uniqueid
    , $name
    , $creatorid
    , $power
    , $shields
    , $faction
    ) {
        $this->uniqueid = $uniqueid;
        $this->name = $name;
        $this->creatorid = $creatorid;
        $this->power = $power;
        $this->shields = $shields;
        $this->faction = $faction;
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
     * @var string The space station's name
     */
    public $name;

    /**
     * @var string The space station creator id
     */
    public $creatorid;
    
    /**
     * @var integer The Space station power
     */
    public $power;
    
    /**
     * @var integer The Space station's shield capacity
     */
    public $shields;
    
    /**
     * @var integer The Space station's faction owner
     */
    public $faction;

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
