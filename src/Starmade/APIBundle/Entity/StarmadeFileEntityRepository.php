<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityRepository;
use Starmade\APIBundle\Entity\StarmadeEntityBuilder;

/**
 * A cache file based StarmadeEntityRepository implementation
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class StarmadeFileEntityRepository extends StarmadeEntityRepository {

  /**
   * @var array data 
   */
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

  public function __construct( StarmadeEntityBuilder $builder , $cacheDir) {
    parent::__construct( $builder );
    
    $this->cacheDir = $cacheDir;
    $this->file = '/sm_' . $this->getType() . '_data';

    if (file_exists($cacheDir . $this->file)) {
      $data = file_get_contents($cacheDir . $this->file);
      $this->data = unserialize($data);
    } else {
      $this->data = $this->parseGameData();
      $this->flush();
    };
  }

  public function findAll() {
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
    foreach ($this->data as $element) {
      $tmp = array(
          "body" => $element,
          "index" => "starmade-gamedata",
          "type" => $this->type,
          "id" => $element->uniqueid,
      );
      $this->client->index($tmp);
    }
  }

  public function count() {
    return count($this->data);
  }

  public function regenerate() {
    unlink($this->cacheDir . "/" . $this->file);

    $this->data = array();

    $this->parseGameData();

    $this->flush();
  }

  public function persists() {
    $this->data[$entity->uniqueid] = $entity;
    ;
  }

}
