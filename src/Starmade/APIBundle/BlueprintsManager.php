<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Blueprint;

class BlueprintsManager {

    /** @var array notes */
    protected $data = array();

    /**
     * @var \Symfony\Component\Security\Core\Util\SecureRandomInterface
     */
    protected $randomGenerator;

    /**
     * @var string
     */
    protected $cacheDir;

    public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
        if (file_exists($cacheDir . '/sm_blueprint_data')) {
            $data = file_get_contents($cacheDir . '/sm_blueprint_data');
            $this->data = unserialize($data);
        } else {
            $this->data = $this->parseGameData();
        }

        $this->randomGenerator = $randomGenerator;
        $this->cacheDir = $cacheDir;
    }

    private function flush() {
        file_put_contents($this->cacheDir . '/sf_note_data', serialize($this->data));
    }

    public function fetch($start = 0, $limit = 5) {
        return array_slice($this->data, $start, $limit, true);
    }

    public function get($id) {
        if (!isset($this->data[$id])) {
            return false;
        }

        return $this->data[$id];
    }

    public function set($note) {
        if (null === $note->id) {
            if (empty($this->data)) {
                $note->id = 0;
            } else {
                end($this->data);
                $note->id = key($this->data) + 1;
            }
        }

        if (null === $note->secret) {
            $note->secret = base64_encode($this->randomGenerator->nextBytes(64));
        }

        $this->data[$note->id] = $note;
        $this->flush();
    }

    public function remove($id) {
        if (!isset($this->data[$id])) {
            return false;
        }

        unset($this->data[$id]);
        $this->flush();

        return true;
    }

    protected function parseGameData() {
        $smDecoder = new SMDecoder();
        
//        $game_dir = $this->getContainer()->getParameter("starmade_dir");
        $game_dir = "F:/areagamer/starmade/server/starmade/StarMade";
        $blueprints = $smDecoder->decodeSMFile( $game_dir . "/server-database/CATALOG.cat");
//        echo "<pre>";
//        print_r( $catalog);
//        echo "</pre>";

        $data = array();

        foreach ($blueprints["cv0"]["pv0"] as $rawBlueprint) {
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

            $data[$blueprint->uniqueid] = $blueprint;
            
        }
        
        return $data;
    }
} 