<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Sector;
use Starmade\APIBundle\Model\Player;
use Starmade\APIBundle\Model\Playerconnection;
use Starmade\APIBundle\StarmadeEntityManager;

class PlayersManager extends StarmadeEntityManager {

    public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
        $this->type = "player";
        parent::__construct($randomGenerator, $cacheDir);
    }

    protected function getPrefix() {
        return "ENTITY_PLAYERCHARACTER_";
    }

    protected function createEntity($playerEntity,$file=null) {
        $uniqueId = $playerEntity["PlayerCharacter"]["id"];
        $name = substr( $file , strpos( $file , "ENTITY_PLAYERCHARACTER_") + strlen("ENTITY_PLAYERCHARACTER_") );    
        $name = str_replace(".ent", "", $name);
        $credits = 0;
        $sector = null;

        // Look for the corresponding player state file
        $stateFile = str_replace( "ENTITY_PLAYERCHARACTER" , "ENTITY_PLAYERSTATE", $file);
        if (file_exists($stateFile)) {
            $charStateEntity = $this->decoder->decodeSMFile($stateFile);
            $credits = intval($charStateEntity["PlayerState"]["credits"]);
            $sectorX = $charStateEntity["PlayerState"]["sector"]["x"];
            $sectorY = $charStateEntity["PlayerState"]["sector"]["y"];
            $sectorZ = $charStateEntity["PlayerState"]["sector"]["z"];
            $sector = new Sector( $sectorX , $sectorY , $sectorZ );
            $faction = $charStateEntity["PlayerState"]["pFac-v0"]["0"];
            
            // Retrieve connectio history
            $connHistory = array();
            if( is_array( $charStateEntity["PlayerState"]["hist"] ) ){
              foreach( $charStateEntity["PlayerState"]["hist"] as $rawConnection ){
                $stamp = round($rawConnection[0] / 1000);
                $ip = $rawConnection[1];
                $playername = $rawConnection[2];
                
                $connection = new Playerconnection( $playername , $stamp , $ip );
                array_push( $connHistory , $connection );
              }
            }
        }
        $player = new Player( $uniqueId, $name, $credits,$sector,$faction , $connHistory );
        
        if($name == "Theck"){
            echo "<pre>";
            print_r($charStateEntity);
            echo "</pre>";
        }


        return $player;
    }

}
