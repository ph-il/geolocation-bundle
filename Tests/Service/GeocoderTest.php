<?php

namespace Phil\GeolocationBundle\Test\Functional;

use Phil\GeolocationBundle\Entity\Address;
use Phil\GeolocationBundle\Service\FormatterService;
use Phil\GeolocationBundle\Service\GeocoderService;
use Geocoder\Geocoder;
use Geocoder\Provider\GoogleMapsProvider;
use Geocoder\HttpAdapter\CurlHttpAdapter;

class GeocoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GeocoderService
     */
    protected $geocoder;

    public function setUp()
    {
        $this->geocoder = new GeocoderService(
            new Geocoder(new GoogleMapsProvider(new CurlHttpAdapter())),
            new FormatterService()
        );
    }

    public function testUS()
    {
        $address = new Address();
        $address->setCountry('US');
        $address->setStreetAddress('300 BOYLSTON AVE E');
        $address->setLocality('Seattle');
        $address->setRegion('WA');
        $address->setPostalCode('98102');

        $this->geocoder->geocode($address);

        $this->assertEquals(47.6210785, $address->getLatitude());
        $this->assertEquals(-122.323045, $address->getLongitude());
    }

    public function testUK()
    {
        $address = new Address();
        $address->setCountry('GB');
        $address->setStreetAddress('96 Euston Road');
        $address->setLocality('London');
        $address->setPostalCode('NW1 2DB');

        $this->geocoder->geocode($address);

        $this->assertEquals(51.5297852, $address->getLatitude());
        $this->assertEquals(-0.1273748, $address->getLongitude());
    }

    public function testHU()
    {
        $address = new Address();
        $address->setCountry('HU');
        $address->setStreetAddress('Bajcsy-Zs. u. 65. 1/3');
        $address->setLocality('Budapest');
        $address->setDistrict('II. kerület');
        $address->setPostalCode('1065');

        $this->geocoder->geocode($address);

        $this->assertEquals(47.497912, $address->getLatitude());
        $this->assertEquals(19.040235, $address->getLongitude());
    }
}