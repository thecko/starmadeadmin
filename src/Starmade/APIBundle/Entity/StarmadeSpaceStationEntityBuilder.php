<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityBuilder;
use Starmade\APIBundle\Model\SpaceStation;
use Starmade\APIBundle\Model\Sector;

/**
 * Implementation of StarmadeEntityBuilder for ships
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class StarmadeSpaceStationEntityBuilder extends StarmadeEntityBuilder {

    public function build($entity, $file = null) {
        $uniqueId = $entity["SpaceStation"]["sc"]["uniqueId"];
        $name = $entity["SpaceStation"]["sc"]["realname"];
        $creatorId = $entity["SpaceStation"]["sc"]["creatoreId"];
        $power = $entity["SpaceStation"]["container"]["pw"];
        $shields = $entity["SpaceStation"]["container"]["sh"];
        $faction = $entity["SpaceStation"]["sc"]["transformable"]["fid"];
        $sectorX = $entity["SpaceStation"]["sc"]["transformable"]["sPos"]["x"];
        $sectorY = $entity["SpaceStation"]["sc"]["transformable"]["sPos"]["y"];
        $sectorZ = $entity["SpaceStation"]["sc"]["transformable"]["sPos"]["z"];
        $sector = new Sector($sectorX, $sectorY, $sectorZ);

//        if (strpos($name, "Night") !== false) {
//        if ( rand(1,100) == 50 ) {
//            echo "<pre>";
//            print_r($spacestationEntity);
//            echo "</pre>";
//            die();
//        }

        $spaceStation = new SpaceStation($uniqueId, $name, $creatorId, $power, $shields, $faction,$sector);

        return $spaceStation;
    }

    public function reinstitute($data) {
        extract($data);

        $entity = new SpaceStation(
                $uniqueid, $name, $creatorid, $power, $shields, $faction , $sector
        );

        return $entity;
    }

    public function getPrefix() {
        return "ENTITY_SPACESTATION_";
    }

    public function getType() {
        return "spacestation";
    }

}
