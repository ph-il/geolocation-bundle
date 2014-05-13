<?php

namespace Phil\GeolocationBundle\Test\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServicesTest extends WebTestCase
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function setUp()
    {
        self::createClient();

        $this->container = self::$kernel->getContainer();
    }

    public function testFormatter()
    {
        $service = $this->container->get('phil.geolocation.address.formatter');
        $className = $this->container->getParameter('phil.geolocation.address.formatter.class');

        $this->assertInstanceOf($className, $service);
    }

    public function testGeocoder()
    {
        $service = $this->container->get('phil.geolocation.address.geocoder');
        $className = $this->container->getParameter('phil.geolocation.address.geocoder.class');

        $this->assertInstanceOf($className, $service);
    }

    public function testGeocodeListener()
    {
        $service = $this->container->get('phil.geolocation.address.geocode_listener');
        $className = $this->container->getParameter('phil.geolocation.address.geocode_listener.class');

        $this->assertInstanceOf($className, $service);
    }

    public function testTwigExtension()
    {
        $service = $this->container->get('phil.geolocation.address.twig_extension');
        $className = $this->container->getParameter('phil.geolocation.address.twig_extension.class');

        $this->assertInstanceOf($className, $service);
    }
} 