<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Planet;
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

        $planet = new Planet( $uniqueId , $factionId );

        return $planet;
    }

}
