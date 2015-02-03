<?php

namespace Starmade\APIBundle\Model;

class AIConfig {
    
    static $AI_TYPE_SHIP = "Ship"; 
    static $AI_TYPE_TURRET = "Turret"; 

    public function __construct(
    $type
    , $target
    , $active
    ) {
        $this->type = $type;
        $this->target = $target;
        $this->active = $active;
    }


    /**
     * @var string AI type (ship or turret)
     */
    public $type;

    /**
     * @var string AI Target (any, current)
     */
    public $target;

    /**
     * @var boolean AI is active
     */
    public $active;
    
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
     * String representation for a faction member
     *
     * @return string
     */
    public function __toString() {
        return $this->type . " " . $this->target;
    }

}
