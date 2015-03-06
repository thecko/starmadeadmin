<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityBuilder;
use Starmade\APIBundle\Model\Planet;
use Starmade\APIBundle\Model\Sector;

/**
 * Implementation of StarmadeEntityBuilder for ships
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class StarmadePlanetEntityBuilder extends StarmadeEntityBuilder {

    public function build($entity, $file = null) {
        $uniqueId = $entity["Planet"]["sc"]["uniqueId"];
        $factionId = $entity["Planet"]["sc"]["transformable"]["fid"]; // ¿ faction id?
        $sectorX = $entity["Planet"]["sc"]["transformable"]["sPos"]["x"];
        $sectorY = $entity["Planet"]["sc"]["transformable"]["sPos"]["y"];
        $sectorZ = $entity["Planet"]["sc"]["transformable"]["sPos"]["z"];
        $sector = new Sector($sectorX, $sectorY, $sectorZ);

        $planet = new Planet( $uniqueId , $factionId , $sector );

        return $planet;
    }

    public function reinstitute($data) {
        extract($data);

        $entity = new Planet(
                $uniqueid, $faction, $sector
        );
        
        return $entity;
    }

    public function getPrefix() {
        return "ENTITY_PLANET_";
    }

    public function getType() {
        return "planet";
    }

}
