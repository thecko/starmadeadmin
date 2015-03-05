<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityBuilder;
use Starmade\APIBundle\Model\Blueprint;

/**
 * Implementation of StarmadeEntityBuilder for blueprint catalog
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class StarmadeBlueprintEntityBuilder extends StarmadeEntityBuilder {

    public function build($entity, $file = null) {

        /*
          [0] => AF-011 Wasp It4  // Blueprint name
          [1] => FrankRa          // Author
          [2] => 0                // ¿?
          [3] => 930886           // Cost
          [4] => no descrption... // Description
          [5] => 0                // ¿?
          [6] => 0                // ¿?
         */

        $uniqueid = md5($entity[0]);
        $name = $entity[0];
        $description = $entity[4];
        $author = $entity[1];
        $cost = $entity[3];

        $blueprint = new Blueprint(
                $uniqueid
                , $name
                , $description
                , $author
                , $cost
        );

        return $blueprint;
    }

    public function reinstitute($data) {
        extract($data);

        $entity = new Blueprint(
                $uniqueid, $name, $description, $author, $cost
        );

        return $entity;
    }

    public function getPrefix() {
        return "";
    }

    public function getType() {
        return "blueprint";
    }

    /**
     * Factions are not one file per entity based, data is in FACTIONS.fac file
     * We'll decode and return the array of data instead of the array of files
     * @param type $gameDir
     * @param type $gameWorld
     * @return array array with the factions data
     */
    public function getEntities($gameDir, $gameWorld) {
        $entities = $this->decoder->decodeSMFile($gameDir . "/server-database/" . $gameWorld . "/CATALOG.cat");
        return $entities["cv0"]["pv0"];
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
