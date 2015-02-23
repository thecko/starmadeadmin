<?php

namespace Starmade\APIBundle\Entity;

/**
 * Stores an snapshot of starmade's game data
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
abstract class StarmadeEntityRepository {
    /**
     * @var string
     */
    protected $type;
    
    /**
     * Returns all the entities
     */
    public abstract function findAll();
    
    /**
     * Returns a single item by it's uniqueid
     */
    public abstract function findById( $uniqueid );
    
    /**
     * The game's entity file will start with this prefix
     */
    protected abstract function getPrefix();

    /**
     * Constructs the object
     * @return A model filled with the game's entity data
     */
    protected abstract function createEntity($entity, $file = null);

    /**
     * Clears the data and reads the game files again
     */
    public abstract function regenerate();
    
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
    
}