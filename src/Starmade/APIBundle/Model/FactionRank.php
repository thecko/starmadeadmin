<?php

namespace Starmade\APIBundle\Model;

class FactionRank {

    public function __construct(
    $id
    , $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }


    /**
     * @var string The faction's rank name
     */
    public $name;

    /**
     * @var int The faction rank id
     */
    public $id;
    
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
        return $this->name;
    }

}
