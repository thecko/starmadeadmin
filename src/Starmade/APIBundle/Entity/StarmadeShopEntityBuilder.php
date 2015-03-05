<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityBuilder;
use Starmade\APIBundle\Model\Shop;
use Starmade\APIBundle\Model\Sector;

/**
 * Implementation of StarmadeEntityBuilder for ships
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class StarmadeShopEntityBuilder extends StarmadeEntityBuilder {

    public function build($entity, $file = null) {
        $uniqueId = $entity["ShopSpaceStation2"]["sc"]["uniqueId"];
        $name = $entity["ShopSpaceStation2"]["sc"]["realname"];
        $creatorId = $entity["ShopSpaceStation2"]["sc"]["creatoreId"];
        $faction = $entity["ShopSpaceStation2"]["sc"]["transformable"]["fid"];
        $sectorX = $entity["ShopSpaceStation2"]["sc"]["transformable"]["sPos"]["x"];
        $sectorY = $entity["ShopSpaceStation2"]["sc"]["transformable"]["sPos"]["y"];
        $sectorZ = $entity["ShopSpaceStation2"]["sc"]["transformable"]["sPos"]["z"];
        $sector = new Sector($sectorX, $sectorY, $sectorZ);

//    if (strpos($name, "Night") !== false) {
//        if (rand(1, 100) == 50) {
//            echo "<pre>";
//            print_r($entity);
//            echo "</pre>";
//            die();
//        }

        $shop = new Shop($uniqueId, $name, $creatorId, $sector);

        return $shop;
    }

    public function reinstitute($data) {
        extract($data);

        $entity = new Shop(
                $uniqueid, $name, $creatorid, $sector
        );

        return $entity;
    }

    public function getPrefix() {
        return "ENTITY_SHOP_";
    }

    public function getType() {
        return "shop";
    }

}
