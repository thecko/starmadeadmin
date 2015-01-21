<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Server;
use Starmade\APIBundle\StarmadeEntityManager;

class FactionsManager extends StarmadeEntityManager {

  public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
    $this->type = "server";
    parent::__construct($randomGenerator, $cacheDir);
  }

  protected function parseGameData() {
    $smDecoder = new SMDecoder();

//        $game_dir = $this->getContainer()->getParameter("starmade_dir");
    $game_dir = "/data/xavi/areagamer/starmade/server/starmade/StarMade";
    $game_dir = "/home/theck/areagamer/starmade/server/starmade/StarMade";
    $rawServer = $smDecoder->checkServ('localhost',4242);

//        echo "<pre>";
//        print_r( $rawFactions);
//        echo "</pre>";
//        die();

    $data = array();

    $server = $this->createEntity($rawServer);
    $data[$server->uniqueid] = $server;

    return $data;
  }

  protected function createEntity($rawServer) {
    $uniqueid = md5( $rawServer["name"] );
    $online = $rawServer["online"];
    $timestamp = new Datetime( $rawServer["timestamp"] );
    $startTime = new Datetime( $rawServer["startTime"] );
    $name = $rawServer["name"];
    $description = $rawServer["description"];

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
