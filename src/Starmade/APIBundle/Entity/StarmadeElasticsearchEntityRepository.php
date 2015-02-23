<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityRepository;

/**
 * An elastic search based StarmadeEntityRepository implementation
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
abstract class StarmadeElasticsearchEntityRepository extends StarmadeEntityRepository {

    public function findAll() {
        
    }

    public function findById($uniqueid) {
        
    }

    public function regenerate() {
        
    }
    
    protected function flush(){
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

}
