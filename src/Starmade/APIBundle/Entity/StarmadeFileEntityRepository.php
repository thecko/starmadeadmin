<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityRepository;

/**
 * A cache file based StarmadeEntityRepository implementation
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
abstract class StarmadeFileEntityRepository extends StarmadeEntityRepository {
    /** @var array data */
    protected $data = array();

    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * @var string
     */
    protected $file;
    
    /**
     * @var \Starmade\Resources\SMDecoder
     */
    protected $decoder;
    
    public function __construct( $cacheDir ) {
        $this->cacheDir = $cacheDir;
        $this->file = '/sm_' . $this->type . '_data';
        
        if (file_exists($cacheDir . $this->file)) {
            $data = file_get_contents($cacheDir . $this->file);
            $this->data = unserialize($data);
        } else {
            $this->data = $this->parseGameData();
            $this->flush();
        };
    }
    
    public function findAll(){
        return $this->data;
    }
    
    public function findById($id) {
        if (!isset($this->data[$id])) {
            return false;
        }

        return $this->data[$id];
    }
    
    public function fetch($start = 0, $limit = 5) {
        return array_values(array_slice($this->data, $start, $limit, true));
    }
    
    protected function flush() {
        foreach( $this->data as $element ){
            $tmp = array(
                "body" => $element,
                "index" => "starmade-gamedata",
                "type" => $this->type,
                "id" => $element->uniqueid,
            );
            $this->client->index( $tmp );
        }
    }
    
    public function count(){
        return count( $this->data );
    }

    protected function parseGameData() {
        // Change the max execution time to allow program parse the huge quantity of files
        $originalExecTime = ini_get('max_execution_time');
        set_time_limit(300);
        ini_set('memory_limit','512M');


        $smDecoder = new SMDecoder();

        $game_dir = $this->getGameDir();

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
            $entity = $this->createEntity($entityData, $entityFile);
            $data[$entity->uniqueid] = $entity;
        }

        // Restore the original max execution time
        set_time_limit($originalExecTime);

        return $data;
    }

    protected abstract function getPrefix();

    public function regenerate() {
        unlink( $this->cacheDir . "/" . $this->file );
    }

    protected function createEntity($entity, $file = null) {
        
    }

}