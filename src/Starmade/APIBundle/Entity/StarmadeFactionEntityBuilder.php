<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityBuilder;
use Starmade\APIBundle\Model\Faction;
use Starmade\APIBundle\Model\FactionMember;
use Starmade\APIBundle\Model\FactionRank;

/**
 * Implementation of StarmadeEntityBuilder for factions
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class StarmadeFactionEntityBuilder extends StarmadeEntityBuilder {

  public function build($entity, $file = null) {
    
    $uniqueid = $entity["id"];
    $name = $entity[1];
    $description = $entity[2];
    $home = $entity["home"];

    // Process members
    $members = array();
    if (is_array($entity["mem"]) && is_array($entity["mem"][0])) {
      foreach ($entity["mem"][0] as $rawMember) {
        $memberName = $rawMember[0];
        $memberRank = $rawMember[1];
        $memberLastConnection = round($rawMember[2] / 1000);

        $member = new FactionMember($memberName, $memberRank, $memberLastConnection, $uniqueid);

        array_push($members, $member);
      }
    }


    // Faction ranks
    $ranks = null;
    $rawRanks = $entity["used_0"][0][2];
    if (is_array($rawRanks)) {
      $ranks = array();
      foreach ($rawRanks as $rankId => $rankName) {
        $rank = new FactionRank($rankId, $rankName);
        array_push($ranks, $rank);
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

  public function reinstitute($data) {
    extract($data);

    $faction = new Faction(
            $uniqueid, $name, $description, $home, $members, $ranks
    );

    return $faction;
  }

  public function getPrefix() {
    return "";
  }

  public function getType() {
    return "faction";
  }

  /**
   * Factions are not one file per entity based, data is in FACTIONS.fac file
   * We'll decode and return the array of data instead of the array of files
   * @param type $gameDir
   * @param type $gameWorld
   * @return array array with the factions data
   */
  public function getEntities($gameDir, $gameWorld) {
    $entities = $this->decoder->decodeSMFile($gameDir . "/server-database/" . $gameWorld . "/FACTIONS.fac");
    return $entities["factions-v0"]["0"]["f0"];
  }

  /**
   * Return the input because the data is already decoded.
   * Because the FACTIONS.fac file was decoded in getEntities method now we
   * don't need to decode it.
   * @param type $file
   * @return type the data file
   */
  public function decode($file) {
    return $file;
  }

}
