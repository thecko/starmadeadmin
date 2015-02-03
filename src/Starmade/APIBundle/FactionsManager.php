<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Faction;
use Starmade\APIBundle\Model\FactionMember;
use Starmade\APIBundle\Model\FactionRank;
use Starmade\APIBundle\StarmadeEntityManager;

class FactionsManager extends StarmadeEntityManager {

  public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
    $this->type = "faction";
    parent::__construct($randomGenerator, $cacheDir);
  }

  protected function parseGameData() {
    $smDecoder = new SMDecoder();


    $game_dir = $this->getGameDir();
    $rawFactions = $smDecoder->decodeSMFile($game_dir . "/server-database/201412/FACTIONS.fac");

//        echo "<pre>";
//        print_r( $rawFactions);
//        echo "</pre>";
//        die();

    $data = array();

    foreach ($rawFactions["factions-v0"][0]["f0"] as $rawFaction) {
      $faction = $this->createEntity($rawFaction);
      $data[$faction->uniqueid] = $faction;
    }

    return $data;
  }

  protected function createEntity($rawFaction , $file = null) {
    $uniqueid = $rawFaction["id"];
    $name = $rawFaction[1];
    $description = $rawFaction[2];
    $home = $rawFaction["home"];
    
    // Process members
    $members = array();
    if( is_array( $rawFaction["mem"]) && is_array( $rawFaction["mem"][0]) ) {
        foreach( $rawFaction["mem"][0] as $rawMember ){
            $memberName = $rawMember[0];
            $memberRank = $rawMember[1];
            $memberLastConnection = round($rawMember[2]/1000);
            
            $member = new FactionMember( $memberName , $memberRank , $memberLastConnection , $uniqueid );
            
            array_push($members, $member);
        }
    }
    
    // Faction ranks
    $ranks = array();
    $rawRanks = $rawFaction["used_0"][0][2];
    foreach( $rawRanks as $rankId => $rankName ){
        $rank = new FactionRank( $rankId , $rankName );
        array_push( $ranks , $rank );
    }

    // Other fields
    // 0 - Hash?
    // ¿3?
    // mem = members (array)
    // ¿4?
    // used_0 Something about ranks        
    //¿pw?
    // ¿fn?
    // ¿en?
    // 5 - A 3d point, maybe coordinates
    // ¿aw?
    // ¿8 -18?
    // 19 an array of points

    $faction = new Faction(
            $uniqueid
            , $name
            , $description
            , $home
            , $members
            , $ranks
    );
    
//    if (strpos($name, "Night") !== false) {
//        echo "<pre>";
//        print_r($rawFaction);
//        echo "</pre>";
//        //die();
//    }
    
    return $faction;
  }

  protected function getPrefix() {
    
  }

}
