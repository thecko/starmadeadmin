<?php

namespace Starmade\APIBundle;

use Symfony\Component\Security\Core\Util\SecureRandomInterface;
use Starmade\APIBundle\Resources\SMDecoder;

abstract class StarmadeEntityManager {

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
    
    /**
     * @var string
     */
    protected $type;
    
    /**
     * @var string
     */
    protected $file;
    
    protected $decoder;

    public function __construct(SecureRandomInterface $randomGenerator, $cacheDir) {
        $this->randomGenerator = $randomGenerator;
        $this->cacheDir = $cacheDir;
        $this->file = '/sm_' . $this->type . '_data';
        
        if (file_exists($cacheDir . $this->file)) {
            $data = file_get_contents($cacheDir . $this->file);
            $this->data = unserialize($data);
        } else {
            $this->data = $this->parseGameData();
            $this->flush();
        }

    }

    private function flush() {
        file_put_contents($this->cacheDir . $this->file, serialize($this->data));
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

    protected function parseGameData() {
        // Change the max execution time to allow program parse the huge quantity of files
        $originalExecTime = ini_get('max_execution_time');
        set_time_limit ( 300 );
        
        $smDecoder = new SMDecoder();

//        $game_dir = $this->getContainer()->getParameter("starmade_dir");
        $game_dir = "/data/xavi/areagamer/starmade/server/starmade/StarMade";
        $game_dir = "/home/theck/areagamer/starmade/server/starmade/StarMade";

        $prefix = $this->getPrefix();
        //exec( "ls " . STARMADE_DIR . "/server-database/DATA/ENTITY_SHIP_*" , $shipFiles );
        $entityFiles = glob($game_dir . "/server-database/201412/" . $prefix . "*");
        //$entityFiles = glob($game_dir . "/db/201412/" . $prefix . "*");
        
        $data = array();

        if (!$entityFiles) {
            return $data;
        }

        foreach ($entityFiles as $count => $entityFile) {
            $this->decoder = new SMDecoder();
            $entityData = $this->decoder->decodeSMFile($entityFile);
            $entity = $this->createEntity($entityData,$entityFile);
            $data[$entity->uniqueid] = $entity;
        }
        
        // Restore the original max execution time
        set_time_limit ( $originalExecTime );

        return $data;
    }
    
    /**
     * The entity file will start with this prefix
     */
    protected abstract function getPrefix();

    /**
     * Constructs the object
     */
    protected abstract function createEntity($entity,$file=null);


} 