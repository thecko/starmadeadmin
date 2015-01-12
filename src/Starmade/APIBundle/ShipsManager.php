<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;
use Starmade\APIBundle\Model\Ship;

class ShipsManager {

    /** @var array data */
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
        
        if (file_exists($cacheDir . '/sm_ship_data')) {
            $data = file_get_contents($cacheDir . '/sm_ship_data');
            $this->data = unserialize($data);
        } else {
            $this->data = $this->parseGameData();
            $this->flush();
        }

    }

    private function flush() {
        file_put_contents($this->cacheDir . '/sm_ship_data', serialize($this->data));
    }

    public function fetch($start = 0, $limit = 5) {
        return array_values( array_slice($this->data, $start, $limit, true) );
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
        $game_dir = "/home/theck/areagamer/starmade/server/starmade/StarMade";

        $prefix = "ENTITY_SHIP_"; //$this->getPrefix();
        //exec( "ls " . STARMADE_DIR . "/server-database/DATA/ENTITY_SHIP_*" , $shipFiles );
        $entityFiles = glob($game_dir . "/server-database/201412/" . $prefix . "*");

        if (!$entityFiles) {
            return null;
        }

        $data = array();

        foreach ($entityFiles as $count => $entityFile) {
            $entity = $this->createEntity($entityFile);
            $data[$entity->uniqueid] = $entity;
        }

        return $data;
    }

    protected function createEntity($file) {
        $decoder = new SMDecoder();

        $shipEntity = $decoder->decodeSMFile($file);

        $name = $shipEntity["sc"]["realname"];
        $uniqueid = $shipEntity["sc"]["uniqueId"];
        $creatorid = $shipEntity["sc"]["creatoreId"];
        $ship = new Ship($uniqueid, $name, $creatorid);

        return $ship;
    }
} 