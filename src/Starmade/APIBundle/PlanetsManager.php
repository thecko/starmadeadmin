<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Planet;
use Starmade\APIBundle\Model\Sector;
use Starmade\APIBundle\StarmadeEntityManager;

class PlanetsManager extends StarmadeEntityManager {

    public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
        $this->type = "planet";
        parent::__construct($randomGenerator, $cacheDir);
    }

    protected function getPrefix() {
        return "ENTITY_PLANET_";
    }

    protected function createEntity($planetEntity , $file = null) {
      
//      echo "<pre>";
//      print_r( $planetEntity );
//      echo "</pre>";
//      die();
      
        $uniqueId = $planetEntity["Planet"]["sc"]["uniqueId"];
        $factionId = $planetEntity["Planet"]["sc"]["transformable"]["fid"]; // ¿ faction id?
        $sectorX = $planetEntity["Planet"]["sc"]["transformable"]["sPos"]["x"];
        $sectorY = $planetEntity["Planet"]["sc"]["transformable"]["sPos"]["y"];
        $sectorZ = $planetEntity["Planet"]["sc"]["transformable"]["sPos"]["z"];
        $sector = new Sector($sectorX, $sectorY, $sectorZ);

        $planet = new Planet( $uniqueId , $factionId , $sector );

        return $planet;
    }

}
