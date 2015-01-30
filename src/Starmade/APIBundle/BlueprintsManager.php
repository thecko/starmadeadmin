<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Blueprint;
use Starmade\APIBundle\StarmadeEntityManager;

class BlueprintsManager extends StarmadeEntityManager {

    public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
        $this->type = "blueprint";
        parent::__construct($randomGenerator, $cacheDir);
    }

    protected function parseGameData() {
        $smDecoder = new SMDecoder();

//        $game_dir = $this->getContainer()->getParameter("starmade_dir");
        $game_dir = $this->getGameDir();
        $blueprints = $smDecoder->decodeSMFile($game_dir . "/server-database/201412/CATALOG.cat");

        $data = array();

        foreach ($blueprints["cv0"]["pv0"] as $rawBlueprint) {
            $blueprint = $this->createEntity($rawBlueprint);
            $data[$blueprint->uniqueid] = $blueprint;
        }

        return $data;
    }

    protected function createEntity($rawBlueprint, $file = null) {
        /*
          [0] => AF-011 Wasp It4  // Blueprint name
          [1] => FrankRa          // Author
          [2] => 0                // ¿?
          [3] => 930886           // Cost
          [4] => no descrption... // Description
          [5] => 0                // ¿?
          [6] => 0                // ¿?
         */

        $uniqueid = md5($rawBlueprint[0]);
        $name = $rawBlueprint[0];
        $description = $rawBlueprint[4];
        $author = $rawBlueprint[1];
        $cost = $rawBlueprint[3];

        $blueprint = new Blueprint(
                $uniqueid
                , $name
                , $description
                , $author
                , $cost
        );

        return $blueprint;
    }

    protected function getPrefix() {
        
    }

}
