<?php

namespace Starmade\APIBundle\Model;

/**
 * Description of Sector
 *
 * @author Theck <jumptard.theck@gmail.com>
 */
class Sector {

    public function __construct(
    $x
    , $y
    , $z
    ) {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    /**
     * @var int x vector component
     */
    public $x;

    /**
     * @var int y vector component
     */
    public $y;
    
    /**
     * @var int z vector component
     */
    public $z;
}
