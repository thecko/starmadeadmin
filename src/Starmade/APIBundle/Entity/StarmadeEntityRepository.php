<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityBuilder;

/**
 * Stores an snapshot of starmade's game data
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
abstract class StarmadeEntityRepository {
    
    /**
     * @var StarmadeEntityBuilder
     */
    protected $builder;
    
    public function __construct(StarmadeEntityBuilder $builder ) {
        $this->builder = $builder;
    }


    /**
     * Returns all the entities
     */
    public abstract function findAll();
    
    /**
     * Returns a single item by it's uniqueid
     */
    public abstract function findById( $uniqueid );
    
    /**
     * Returns how many items are in the repository
     */
    public abstract function count();
    
    /**
     * Clears the data and reads the game files again
     */
    public abstract function regenerate();
    
    /**
     * Persists the entity
     */
    public abstract function persists();
    
    /**
     * The game's entity file will start with this prefix
     */
    protected function getPrefix(){
        return $this->builder->getPrefix();
    }
    
    /**
     * The game's entity file will start with this prefix
     */
    protected function getType(){
        return $this->builder->getType();
    }
    
    /**
     * Returns the path to the game
     * @return string the game's path
     */
    public function getGameDir() {
//        $game_dir = $this->getContainer()->getParameter("starmade_dir");
        $game_dir = "/data/xavi/areagamer/starmade/server/starmade/StarMade";
        $game_dir = "/home/theck/areagamer/starmade/server/starmade/StarMade";

        return $game_dir;
    }
    
    /**
     * Returns the observed game world
     * @return string the world folder name
     */
    public function getGameWorld(){
        return "201412";
    }
    
    protected function parseGameData() {
        // Change the max execution time to allow program parse the huge quantity of files
        $originalExecTime = ini_get('max_execution_time');
        $originalMemLimit = ini_get('memory_limit');
        set_time_limit(300);
        ini_set('memory_limit','512M');


        $smDecoder = new SMDecoder();

        $gameDir = $this->getGameDir();
        $gameWorld = $this->getGameWorld();

        $prefix = $this->getPrefix();
        $entityFiles = glob($gameDir . "/server-database/" . $gameWorld . "/" . $prefix . "*");

        if (!$entityFiles) {
            return false;
        }

        foreach ($entityFiles as $count => $entityFile) {
            $this->decoder = new SMDecoder();
            $entityData = $this->decoder->decodeSMFile($entityFile);
            $entity = $builder->build( $entityData , $entityFile );
            $this->persists( $entity );
        }

        // Restore the original max execution time
        set_time_limit($originalExecTime);
        ini_set('memory_limit',$originalMemLimit);

        return true;
    }
    
}