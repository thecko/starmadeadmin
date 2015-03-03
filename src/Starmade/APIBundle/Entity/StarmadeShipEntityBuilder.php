<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityBuilder;
use Starmade\APIBundle\Model\Ship;
use Starmade\APIBundle\Model\Sector;
use Starmade\APIBundle\Model\AIConfig;

/**
 * Implementation of StarmadeEntityBuilder for ships
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class StarmadeShipEntityBuilder extends StarmadeEntityBuilder {

    public function build($entity, $file = null) {
        $name = $entity["sc"]["realname"];
        $uniqueid = $entity["sc"]["uniqueId"];
        $creatorid = $entity["sc"]["creatoreId"];
        $mass = $entity["sc"]["transformable"]["mass"];
        $power = $entity["sc"]["container"]["pw"];
        $shields = $entity["sc"]["container"]["sh"];
        $sectorX = $entity["sc"]["transformable"]["sPos"]["x"];
        $sectorY = $entity["sc"]["transformable"]["sPos"]["y"];
        $sectorZ = $entity["sc"]["transformable"]["sPos"]["z"];
        $sector = new Sector($sectorX, $sectorY, $sectorZ);
        $aIType = $entity["sc"]["container"]["AIConfig1"][0][1];
        $aITarget = $entity["sc"]["container"]["AIConfig1"][2][1];
        $aIActive = $entity["sc"]["container"]["AIConfig1"][1][1] === "true";
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

        $ship = new Ship(
                $uniqueid, $name, $creatorid, $mass, $power, $shields, $sector, $aIConfig
        );

        return $ship;
    }

    public function reinstitute($data) {
        extract($data);

        $ship = new Ship(
                $uniqueid, $name, $creatorid, $mass, $power, $shields, $sector, $aIConfig
        );

        return $ship;
    }

    public function getPrefix() {
        return "ENTITY_SHIP_";
    }

    public function getType() {
        return "ship";
    }

}
