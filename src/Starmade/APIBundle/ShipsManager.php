<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Ship;
use Starmade\APIBundle\StarmadeEntityManager;

class ShipsManager extends StarmadeEntityManager {

    public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
        $this->type = "ship";
        parent::__construct($randomGenerator, $cacheDir);
    }

    protected function getPrefix() {
        return "ENTITY_SHIP_";
    }

    protected function createEntity($shipEntity) {
        $name = $shipEntity["sc"]["realname"];
        $uniqueid = $shipEntity["sc"]["uniqueId"];
        $creatorid = $shipEntity["sc"]["creatoreId"];
        $ship = new Ship($uniqueid, $name, $creatorid);

        return $ship;
    }

}