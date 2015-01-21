<?php

namespace Starmade\APIBundle\Model;

class Server {

    public function __construct(
    $uniqueid
    , $online
    , $timestamp
    , $version
    , $name
    , $description
    , $startTime
    , $connected
    , $maxPlayers
    ) {
        $this->uniqueid = $uniqueid;
        $this->online = $online;
        $this->timestamp = $timestamp;
        $this->version = $version;
        $this->name = $name;
        $this->description = $description;
        $this->startTime = $startTime;
        $this->connected = $connected;
        $this->maxPlayers = $maxPlayers;
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
     * @var boolean
     */
    public $online;
    
    /**
     * @var datetime
     */
    public $timestamp;
    
    /**
     * @var datetime
     */
    public $startTime;
    
    /**
     * @var int
     */
    public $connected;
    
    /**
     * @var int
     */
    public $maxPlayers;

    /**
     * @var string The server name
     */
    public $name;

    /**
     * @var string The server description
     */
    public $description;

    /**
     * @var string The original version
     */
    public $version = 1;

    /**
     * @var string This version will be used since 1.1
     */
    public $new_version = 1.1;
    
    /**
     * String representation for a server
     *
     * @return string
     */
    public function __toString() {
        return $this->name;
    }

}
