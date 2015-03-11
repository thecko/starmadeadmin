<?php

namespace Starmade\APIBundle\Entity;

/**
 * Container to store a query resulset from the entity repository
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class StarmadeEntityResultset {
    protected $data;
    protected $count;
    
    public function __construct( $data , $count ) {
        $this->data = $data;
        $this->count = $count;
    }
    
    public function data() {
       return $this->data;
    }
    
    public function count() {
       return $this->count;
    }
}
