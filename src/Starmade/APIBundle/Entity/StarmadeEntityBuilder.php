<?php

namespace Starmade\APIBundle\Entity;

/**
 * Extract the data from a game file to a model
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
abstract class StarmadeEntityBuilder {
  
  /**
   * From the game file data fills the corresponding model
   */
  public abstract static function build( $entity, $file = null );
  
  /**
   * Returns the Starmade's file prefix name
   */
  public abstract static function getPrefix();
  
  /**
   * Returns our internal name
   */
  public abstract static function getType();
}
