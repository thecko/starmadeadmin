<?php

namespace Starmade\APIBundle\Model;

class Faction {

    public function __construct(
    $uniqueid
    , $name
    , $description
    , $home
    , $members
    ) {
        $this->uniqueid = $uniqueid;
        $this->name = $name;
        $this->description = $description;
        $this->members = $members;
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
     * @var string The faction name
     */
    public $name;

    /**
     * @var string The faction description
     */
    public $description;

    /**
     * @var string The faction's home
     */
    public $home;
    
    /**
     * @var FactionMember[] The faction's members
     */
    public $members;

    /**
     * @var string The original version
     */
    public $version = 1;

    /**
     * @var string This version will be used since 1.1
     */
    public $new_version = 1.1;
    
    /**
     * @var int
     */
    public $cost;

    /**
     * String representation for a faction
     *
     * @return string
     */
    public function __toString() {
        return $this->name;
    }

}
