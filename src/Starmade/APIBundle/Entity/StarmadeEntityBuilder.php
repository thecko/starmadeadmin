<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Resources\SMDecoder;

/**
 * Extract the data from a game file to a model
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
abstract class StarmadeEntityBuilder {
  
  protected $decoder;
  
  public function __construct() {
    $this->decoder = new SMDecoder();
  }
  
  /**
   * From the game file data fills the corresponding model
   */
  public abstract function build( $entity, $file = null );
  
  /**
   * From a data array from a repository, re-create the model
   */
  public abstract function reinstitute( $data );
  
  /**
   * Returns the Starmade's file prefix name
   */
  public abstract function getPrefix();
  
  /**
   * Returns our internal name
   */
  public abstract function getType();
  
  public function getEntities( $gameDir , $gameWorld ){
      
      $prefix = $this->getPrefix();
        
      $entities = glob($gameDir . "/server-database/" . $gameWorld . "/" . $prefix . "*");
      
      return $entities;
    }
    
    public function decode( $file ){
      return $this->decoder->decodeSMFile( $file );
    }
  
}
