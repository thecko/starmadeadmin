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
        
//        $this->regenerate();
        
        if ( !$this->indexExists() ) {
            $this->parseGameData();
        }
        
    }

    public function findAll( $start = 0, $limit = 10 ) {
        $data = $this->client->search( array(
           "index" => $this->index,
           "type" => $this->getType(),
        ));
        $results = array();
        foreach( $data["hits"] as $data ){
            $obj = $this->builder->reinstitute($data);
        echo "<pre>";
        print_r($obj);
        echo "</pre>";
            die();
        }
        return $data;
    }

    public function findById($uniqueid) {
        
    }

    public function regenerate() {

        if ( $this->indexExists() ) {
            $this->client->indices()->delete(array(
                "index" => $this->index,
            ));
        }

        $this->parseGameData();
        
    }
    
    public function indexExists(){
        return $this->client->indices()->exists(array(
            "index" => $this->index,
        ));
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
