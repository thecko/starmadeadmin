<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Faction;

class FactionsManager {

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
        $this->randomGenerator = $randomGenerator;
        $this->cacheDir = $cacheDir;

        if (file_exists($cacheDir . '/sm_faction_data')) {
            $data = file_get_contents($cacheDir . '/sm_faction_data');
            $this->data = unserialize($data);
        } else {
            $this->data = $this->parseGameData();
            $this->flush();
        }
    }

    private function flush() {
        file_put_contents($this->cacheDir . '/sm_blueprint_data', serialize($this->data));
    }

    public function fetch($start = 0, $limit = 5) {
        return array_values(array_slice($this->data, $start, $limit, true));
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
        $game_dir = "/data/xavi/areagamer/starmade/server/starmade/StarMade";
        $rawFactions = $smDecoder->decodeSMFile($game_dir . "/server-database/201412/FACTIONS.fac");
//        echo "<pre>";
//        print_r( $catalog);
//        echo "</pre>";

        $data = array();

        foreach ($rawFactions["factions-v0"][0]["f0"] as $rawFaction) {
            $uniqueid = $rawFaction["id"];
            $name = $rawFaction[1];
            $description = $rawFaction[2];
            $home = $rawFaction["home"];

            // Other fields
            // 0 - Hash?
            // ¿3?
            // mem = members (array)
            // ¿4?
            // used_0 Something about ranks        
            //¿pw?
            // ¿fn?
            // ¿en?
            // 5 - A 3d point, maybe coordinates
            // ¿aw?
            // ¿8 -18?
            // 19 an array of points

            $faction = new Faction(
                    $uniqueid
                    , $name
                    , $description
                    , $home
            );

            $factions[$faction->uniqueid] = $faction;
        }

        return $data;
    }

}
