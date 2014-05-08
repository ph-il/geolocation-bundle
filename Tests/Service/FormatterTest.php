<?php

namespace Phil\GeolocationBundle\Test\Functional;

use Phil\GeolocationBundle\Entity\Address;
use Phil\GeolocationBundle\Service\FormatterService;

/**
 * Class FormatterTest
 *
 * @package Phil\GeolocationBundle\Test\Functional
 */
class FormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormatterService
     */
    protected $formatter;

    public function setUp()
    {
        $this->formatter = new FormatterService();
    }

    public function testUS()
    {
        $address = new Address();
        $address->setCountry('us');
        $address->setStreetAddress('300 BOYLSTON AVE E');
        $address->setLocality('Seattle');
        $address->setRegion('WA');
        $address->setPostalCode('98102');

        $this->assertEquals(file_get_contents(__DIR__ . '/../Resources/fixtures/address_US.txt'), $this->formatter->format($address));
    }

    public function testUK()
    {
        $address = new Address();
        $address->setCountry('GB');
        $address->setStreetAddress('96 Euston Road');
        $address->setLocality('London');
        $address->setPostalCode('NW1 2DB');

        $this->assertEquals(file_get_contents(__DIR__ . '/../Resources/fixtures/address_UK.txt'), $this->formatter->format($address));
    }

    public function testHU()
    {
        $address = new Address();
        $address->setCountry('HU');
        $address->setStreetAddress('Bajcsy-Zs. u. 65. 1/3');
        $address->setLocality('Budapest');
        $address->setDistrict('II. kerület');
        $address->setPostalCode('1065');

        $this->assertEquals(file_get_contents(__DIR__ . '/../Resources/fixtures/address_HU.txt'), $this->formatter->format($address));
    }
}