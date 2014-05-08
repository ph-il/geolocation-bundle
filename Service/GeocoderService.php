<?php

namespace Phil\GeolocationBundle\Service;

use Geocoder\GeocoderInterface;
use Phil\GeolocationBundle\Entity\GeocodeInterface;

/**
 * Class GeocoderService
 *
 * @package Phil\GeolocationBundle\Service
 */
class GeocoderService
{
    /**
     * @var GeocoderInterface
     */
    protected $geocoder;

    /**
     * @var FormatterService
     */
    protected $formatter;

    /**
     * @param GeocoderInterface $geocoder
     * @param FormatterService  $formatter
     */
    public function __construct(GeocoderInterface $geocoder, FormatterService $formatter)
    {
        $this->geocoder  = $geocoder;
        $this->formatter = $formatter;
    }

    /**
     * @param GeocodeInterface $address
     */
    public function geocode(GeocodeInterface $address)
    {
        try {
            $coords = $this->geocoder->geocode($this->formatter->format($address, FormatterService::FLAG_NOBR));
        } catch (\Exception $e) {
            $coords = array(
                'latitude'  => 0,
                'longitude' => 0,
            );
        }

        $address->setLatitude($coords['latitude']);
        $address->setLongitude($coords['longitude']);
    }
}
