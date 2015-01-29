<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Shop;
use Starmade\APIBundle\StarmadeEntityManager;

class ShopsManager extends StarmadeEntityManager {

    public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
        $this->type = "shop";
        parent::__construct($randomGenerator, $cacheDir);
    }

    protected function getPrefix() {
        return "ENTITY_SHOP_";
    }

    protected function createEntity($shopEntity, $file = null) {
        $uniqueId = $shopEntity["ShopSpaceStation2"]["sc"]["uniqueId"];
        $name = $shopEntity["ShopSpaceStation2"]["sc"]["realname"];
        $creatorId = $shopEntity["ShopSpaceStation2"]["sc"]["creatoreId"];

        $shop = new Shop($uniqueId, $name, $creatorId);

        return $shop;
    }

}
