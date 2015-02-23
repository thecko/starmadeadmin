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
}
