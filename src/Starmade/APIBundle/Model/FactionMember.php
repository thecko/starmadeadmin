<?php

namespace Starmade\APIBundle\Model;

class FactionMember {

    public function __construct(
    $name
    , $rank
    , $lastConnection
    , $factionId
    ) {
        $this->name = $name;
        $this->rank = $rank;
        $this->lastConnection = \DateTime::createFromFormat("U" ,  $lastConnection );
        $this->factionId = $factionId;
    }


    /**
     * @var string The faction's member name
     */
    public $name;

    /**
     * @var int The faction rank
     */
    public $rank;
    
    /**
     * @var DateTime The member's last connection
     */
    public $lastConnection;
    
    /**
     * @var int The parent faction id
     */
    public $factionId;
    
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
