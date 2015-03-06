<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityBuilder;
use Starmade\APIBundle\Model\Server;

/**
 * Implementation of StarmadeEntityBuilder for ships
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class StarmadeServerEntityBuilder extends StarmadeEntityBuilder {

    public function build($entity, $file = null) {
        
        $uniqueid = md5( $entity["name"] );
        $online = $entity["online"];
        $timestamp = \DateTime::createFromFormat("U" , round($entity["timestamp"]/1000) );
        $startTime = \DateTime::createFromFormat("U" , round($entity["startTime"]/1000) );
        $name = $entity["name"];
        $description = $entity["description"];
        $version = "";
        $connected = "";
        $maxPlayers = "";
        
        $server = new Server(
                $uniqueid, $online, $timestamp, $version, $name, $description, $startTime, $connected, $maxPlayers
            );
    }

    public function reinstitute($data) {
        extract($data);

        $ship = new Server(
                $uniqueid, $online, $timestamp, $version, $name, $description, $startTime, $connected, $maxPlayers
        );

        return $ship;
    }

    public function getPrefix() {
    }

    public function getType() {
        return "server";
    }
    
    public function getEntities( $gameDir , $gameWorld ){
        try{
            $originalErrorReporting = error_reporting();
            error_reporting( 0 );
            
            $entities = array($this->decoder->checkServ('localhost',4242));
            
            error_reporting( $originalErrorReporting );
        }
        catch( Exception $e ){
            $entities = null;
        }
        return $entities;
    }
    
    public function decode( $file ){
        return $file;
    }

}
