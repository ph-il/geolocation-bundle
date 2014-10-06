<?php

namespace Phil\GeolocationBundle\Twig\Extension;

use League\Geotools\AbstractGeotools;
use League\Geotools\Distance\Distance;
use Phil\GeolocationBundle\ORM\Point;

class DistanceExtension extends \Twig_Extension
{
    /**
     * @var Distance
     */
    public $distance;

    /**
     * @param Distance $distance
     */
    public function __construct(Distance $distance)
    {
        $this->distance = $distance;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'distance' => new \Twig_Filter_Method($this, 'distance')
        );
    }

    public function distance(Point $from, Point $to, $flags = AbstractGeotools::KILOMETER_UNIT)
    {
        return $this->distance->setFrom($from)->setTo($to)->in($flags)->vincenty();
    }

    /**
     * Name of this extension
     *
     * @return string
     */
    public function getName()
    {
        return 'distance';
    }
}
