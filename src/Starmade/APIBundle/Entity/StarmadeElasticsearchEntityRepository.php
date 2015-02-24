<?php

namespace Starmade\APIBundle\Entity;

use Starmade\APIBundle\Entity\StarmadeEntityRepository;
use Elasticsearch\Client;

/**
 * An elastic search based StarmadeEntityRepository implementation
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
abstract class StarmadeElasticsearchEntityRepository extends StarmadeEntityRepository {

    public $client;
    public $index;

    public function __construct() {
        $parent::__construct();

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

        $this->flush();
    }

    protected function flush() {
        foreach ($this->data as $element) {
            $tmp = array(
                "body" => $element,
                "index" => $this->index,
                "type" => $this->getType(),
                "id" => $element->uniqueid,
            );
            $this->client->index($tmp);
        }
    }

    public function persists($element) {
        $tmp = array(
            "body" => $element,
            "index" => "starmade-gamedata",
            "type" => $this->type,
            "id" => $element->uniqueid,
        );
        $this->client->index($tmp);
    }

}
