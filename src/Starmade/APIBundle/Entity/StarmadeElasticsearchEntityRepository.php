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

    public function __construct(StarmadeEntityBuilder $builder) {
        parent::__construct($builder);

        $this->client = new Client();
        $this->index = "starmade-gamedata";

        if ($this->needToRegenerate()) {
            $this->parseGameData();
        }
    }

    public function findAll($start = 0, $limit = 10) {
        $data = $this->client->search(array(
            "index" => $this->index,
            "type" => $this->getType(),
            "from" => $start,
            "size" => $limit,
        ));
        $results = array();
        foreach ($data["hits"]["hits"] as $row) {
            $obj = $this->builder->reinstitute($row["_source"]);
            array_push($results, $obj);
        }
        return $results;
    }

    public function findById($uniqueid) {
        try {
            $data = $this->client->get(array(
                "index" => $this->index,
                "type" => $this->getType(),
                "id" => $uniqueid,
            ));
            $obj = $this->builder->reinstitute($data["_source"]);
        } catch (Exception $e) {
            $obj = false;
        }
        return $obj;
    }

    public function regenerate() {

        // TODO delete only the type data not the whole index

        $this->client->indices()->delete(array(
            "index" => $this->index,
        ));

        $this->parseGameData();
    }

    public function needToRegenerate() {
        return false;
        return $this->client->indices()->exists(array(
                    "index" => $this->index,
        ));
    }

    protected function flush() {
        
    }

    public function persists($element) {
        $tmp = array(
            "body" => $element,
            "index" => $this->index,
            "type" => $this->getType(),
            "timestamp" => time(),
            "id" => $element->uniqueid,
        );
        $this->client->index($tmp);
    }

    public function count() {
        $count = $this->client->count(array(
            'index' => $this->index,
            'type' => $this->getType(),
        ));
        return $count["count"];
    }

}
