<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Faction;
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
    );
    
    return $faction;
  }

  protected function getPrefix() {
    
  }

}
