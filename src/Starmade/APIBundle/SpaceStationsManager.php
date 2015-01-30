<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\SpaceStation;
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
        $faction = $spacestationEntity["SpaceStation"]["sc"]["fid"];

        $spaceStation = new SpaceStation($uniqueId, $name, $creatorId, $power, $shields, $faction);

        return $spaceStation;
    }

}
