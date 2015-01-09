<?php

namespace Starmade\APIBundle\Model;

class Blueprint {

    public function __construct(
    $uniqueid
    , $name
    , $description
    , $author
    , $cost
    ) {
        $this->uniqueid = $uniqueid;
        $this->name = $name;
        $this->description = $description;
        $this->author = $author;
        $this->cost = $cost;
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
     * @var string The blueprint name
     */
    public $name;

    /**
     * @var string The blueprint description
     */
    public $description;

    /**
     * @var string The blueprint author
     */
    public $author;

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
     * String representation for a blueprint
     *
     * @return string
     */
    public function __toString() {
        return $this->name;
    }

}
