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
        
        //$this->regenerate();

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
        $obj = false;
        $params = array();
        $params["index"] = $this->index;
        $params["type"] = $this->getType();
        $params["id"] = $uniqueid;
        if ($this->client->exists($params)) {
            $data = $this->client->get($params);
            $obj = $this->builder->reinstitute($data["_source"]);
        }
        return $obj;
    }

    public function regenerate() {

        $params = array();
        $params['index'] = $this->index;
        $params['type'] = $this->getType();
        $params['body']['query']['must']['match_all'] = '';
        $this->client->deleteByQuery($params);
        die();

        $this->parseGameData();
    }

    /**
     * If there are elements outdated, we'll to regenerate the index
     * @return boolean if regeneration is needed
     */
    public function needToRegenerate() {
        
        // First look for the index
        $indexExists = $this->client->indices()->exists(array(
            "index" => $this->index,
        ));
        
        if( !$indexExists ){
          
          $indexExists = $this->client->indices()->create(array(
            "index" => $this->index,
          ));
          
          return true;
        }
        
        // Then, it maybe empty
        $count = $this->client->count(array(
            "index" => $this->index,
            "type" => $this->getType(),
        ));
        if( $count["count"] == 0 ){
          return true;
        }
        
        
        // Finaly, look if there is outdated entries
        $outdated = $this->getOutDated();

        $params['index'] = $this->index;
        $params['type'] = $this->getType();
        $params['body']['query']['range']['timestamp']['lt'] = $outdated->getTimestamp();
        $data = $this->client->search($params);

        if( $data["hits"]["total"] > 0 ){
            return true;
        }
        
        
        return false;
    }

    protected function flush() {}

    public function persists($element) {
        $body = (array)$element;
        $body["timestamp"] = time();
        $tmp = array(
            "body" => $body,
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
    
    public function getOutDated(){
        // TODO as a parameter
        $outdated = new \Datetime();
//        $outdated->modify('1 month ago');
        $outdated->modify('1 minute ago');
        
        return $outdated;
    }

}
