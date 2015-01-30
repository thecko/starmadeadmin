<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Faction;
use Starmade\APIBundle\Model\FactionMember;
use Starmade\APIBundle\StarmadeEntityManager;

class FactionsManager extends StarmadeEntityManager {

  public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
    $this->type = "faction";
    parent::__construct($randomGenerator, $cacheDir);
  }

  protected function parseGameData() {
    $smDecoder = new SMDecoder();

//        $game_dir = $this->getContainer()->getParameter("starmade_dir");
    $game_dir = "/data/xavi/areagamer/starmade/server/starmade/StarMade";
    $game_dir = "/home/theck/areagamer/starmade/server/starmade/StarMade";
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
            $memberLastConnection = $rawMember[2];
            
            $member = new FactionMember( $memberName , $memberRank , $memberLastConnection , $uniqueid );
            
            array_push($members, $member);
        }
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
    );
    
    if (strpos($name, "Night") !== false) {
        echo "<pre>";
        print_r($rawFaction);
        echo "</pre>";
        die();
    }
    
    return $faction;
  }

  protected function getPrefix() {
    
  }

}
