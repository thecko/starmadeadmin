<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Ship;
use Starmade\APIBundle\Model\Sector;
use Starmade\APIBundle\Model\AIConfig;
use Starmade\APIBundle\StarmadeEntityManager;

class ShipsManager extends StarmadeEntityManager {

    public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
        $this->type = "ship";
        parent::__construct($randomGenerator, $cacheDir);
    }

    protected function getPrefix() {
        return "ENTITY_SHIP_";
    }

    protected function createEntity($shipEntity, $file = null) {
        $name = $shipEntity["sc"]["realname"];
        $uniqueid = $shipEntity["sc"]["uniqueId"];
        $creatorid = $shipEntity["sc"]["creatoreId"];
        $mass = $shipEntity["sc"]["transformable"]["mass"];
        $power = $shipEntity["sc"]["container"]["pw"];
        $shields = $shipEntity["sc"]["container"]["sh"];
        $sectorX = $shipEntity["sc"]["transformable"]["sPos"]["x"];
        $sectorY = $shipEntity["sc"]["transformable"]["sPos"]["y"];
        $sectorZ = $shipEntity["sc"]["transformable"]["sPos"]["z"];
        $sector = new Sector($sectorX, $sectorY, $sectorZ);
        $aIType = $shipEntity["sc"]["container"]["AIConfig1"][0][1];
        $aITarget = $shipEntity["sc"]["container"]["AIConfig1"][2][1];
        $aIActive = $shipEntity["sc"]["container"]["AIConfig1"][1][1] === "true";
        $aIConfig = new AIConfig($aIType, $aITarget, $aIActive);

//        if (strpos($name, "test-ship") !== false) {
//            echo "<pre>";
//            print_r($shipEntity);
//            echo "</pre>";
//            $extraDataFile = str_replace("/server-database/201412/" , "/server-database/201412/DATA/" , $file);
//            $extraDataFile = str_replace(".ent" , ".0.0.0.smd2" , $extraDataFile );
//            $extraData = $this->decoder->decodeSMFile( $extraDataFile );
//            echo "<hr /><pre>";
//            print_r($extraData);
//            echo "</pre>";
//            die();
//        }


        $ship = new Ship($uniqueid, $name, $creatorid, $mass, $power, $shields, $sector, $aIConfig);

        return $ship;
    }

}
