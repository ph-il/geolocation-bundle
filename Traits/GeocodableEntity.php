<?php

namespace Phil\GeolocationBundle\Traits;

use Phil\GeolocationBundle\ORM\Point;

/**
 * Description of Address
 *
 * @author Philippe Gamache
 *
 *
 */
trait GeocodableEntity
{
    /**
     * @ORM\Column(type="point")
     *
     * @var Point
     */
    protected $latitudeLongitude;

    /**
     * @param $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->getLatitudeLongitude()->setLatitude($latitude);

        return $this;
    }

    /**
     * @return Point
     */
    public function getLatitudeLongitude()
    {
        return $this->latitudeLongitude;
    }

    /**
     * @param Point $latitudeLongitude
     */
    public function setLatitudeLongitude(Point $latitudeLongitude)
    {
        $this->latitudeLongitude = $latitudeLongitude;

        return $this;
    }

    /**
     * @param $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->getLatitudeLongitude()->setLongitude($longitude);

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->getLatitudeLongitude()->getLatitude();
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->getLatitudeLongitude()->getLongitude();
    }

}

