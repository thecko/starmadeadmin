<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityRepository;
use Elasticsearch\Client;

/**
 * An elastic search based StarmadeEntityRepository implementation
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class StarmadeElasticsearchEntityRepository extends StarmadeEntityRepository {

    public $client;
    public $index;

    public function __construct( StarmadeEntityBuilder $builder ) {
        parent::__construct( $builder );

        $this->client = new Client();
        $this->index = "starmade-gamedata";
    }

    public function findAll() {
        
    }

    public function findById($uniqueid) {
        
    }

    public function regenerate() {
        $indexExists = $this->client->indices()->exists(array(
            "index" => $this->index,
        ));

        if ($indexExists) {
            $this->client->indices()->delete(array(
                "index" => $this->index,
            ));
        }

        $this->parseGameData();
        
    }

    protected function flush() {}

    public function persists($element) {
        $tmp = array(
            "body" => $element,
            "index" => $this->index,
            "type" => $this->getType(),
            "id" => $element->uniqueid,
        );
        $this->client->index($tmp);
    }

  public function count() {
    $this->client->indexes( array( 'index' => $this->index ) )->count();
  }

}
