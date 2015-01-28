<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Player;
use Starmade\APIBundle\StarmadeEntityManager;

class PlayersManager extends StarmadeEntityManager {

    public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
        $this->type = "player";
        parent::__construct($randomGenerator, $cacheDir);
    }

    protected function getPrefix() {
        return "ENTITY_PLAYER_";
    }

    protected function createEntity($playerEntity) {
        echo "<pre>";
        print_r( $playerEntity );
        echo "</pre>";
        die();
        $uniqueId = $playerEntity["ShopSpaceStation2"]["sc"]["uniqueId"];
        $name = $playerEntity["ShopSpaceStation2"]["sc"]["realname"];
        $creatorId = $playerEntity["ShopSpaceStation2"]["sc"]["creatoreId"];

        $shop = new Shop( $uniqueId, $name, $creatorId );

        return $shop;
    }

}
