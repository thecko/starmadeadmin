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

  protected function createEntity($spacestationEntity) {
    $uniqueId = $spacestationEntity["SpaceStation"]["sc"]["uniqueId"];
    $name = $spacestationEntity["SpaceStation"]["sc"]["realname"];
    $creatorId = $spacestationEntity["SpaceStation"]["sc"]["creatoreId"];

    $spaceStation = new SpaceStation($uniqueId, $name, $creatorId);

    return $spaceStation;
  }

}
