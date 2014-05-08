<?php

namespace Phil\GeolocationBundle\Entity;

use Phil\GeolocationBundle\ORM\Point;

/**
 * Interface GeocodeInterface
 *
 * @package Phil\GeolocationBundle\Entity
 */
interface GeocodeInterface
{

    /**
     * @return Point
     */
    public function getLatitudeLongitude();

    /**
     * Set latitude
     *
     * @param integer $latitude
     */
    public function setLatitude($latitude);

    /**
     * Get latitude
     *
     * @return integer
     */
    public function getLatitude();

    /**
     * Set longitude
     *
     * @param integer $longitude
     */
    public function setLongitude($longitude);

    /**
     * Get longitude
     *
     * @return integer
     */
    public function getLongitude();
}
