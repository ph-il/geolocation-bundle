<?php

namespace Phil\GeolocationBundle\ORM;

use League\Geotools\Coordinate\Coordinate;

/**
 * Point object for spatial mapping
 */
class Point extends Coordinate
{

    /**
     * @return string
     */
    public function getLatitudeLongitude()
    {
        return $this->latitude . ',' . $this->longitude;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        //Output from this is used with POINT_STR in DQL so must be in specific format
        return sprintf('POINT(%f %f)', $this->latitude, $this->longitude);
    }

}