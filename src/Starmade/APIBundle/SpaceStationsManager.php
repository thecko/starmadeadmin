<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\SpaceStation;
use Starmade\APIBundle\Model\Sector;
use Starmade\APIBundle\StarmadeEntityManager;

class SpaceStationsManager extends StarmadeEntityManager {

    public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
        $this->type = "spacestation";
        parent::__construct($randomGenerator, $cacheDir);
    }

    protected function getPrefix() {
        return "ENTITY_SPACESTATION_";
    }

    protected function createEntity($spacestationEntity, $file = null) {
        $uniqueId = $spacestationEntity["SpaceStation"]["sc"]["uniqueId"];
        $name = $spacestationEntity["SpaceStation"]["sc"]["realname"];
        $creatorId = $spacestationEntity["SpaceStation"]["sc"]["creatoreId"];
        $power = $spacestationEntity["SpaceStation"]["container"]["pw"];
        $shields = $spacestationEntity["SpaceStation"]["container"]["sh"];
        $faction = $spacestationEntity["SpaceStation"]["sc"]["transformable"]["fid"];
        $sectorX = $spacestationEntity["SpaceStation"]["sc"]["transformable"]["sPos"]["x"];
        $sectorY = $spacestationEntity["SpaceStation"]["sc"]["transformable"]["sPos"]["y"];
        $sectorZ = $spacestationEntity["SpaceStation"]["sc"]["transformable"]["sPos"]["z"];
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

}
