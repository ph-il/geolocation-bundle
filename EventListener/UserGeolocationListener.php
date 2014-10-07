<?php
/**
 * User: PGamach1
 * Date: 2014-06-05
 * Time: 12:57 PM
 *
 */

namespace Phil\GeolocationBundle\EventListener;

use Geocoder\GeocoderInterface;
use Phil\GeolocationBundle\ORM\Point;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class UserGeolocationListener
{

    const COOKIE_NAME = 'phil-geolocation';

    /**
     * @var GeocoderInterface
     */
    protected $geocoder;

    function __construct(GeocoderInterface $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    public function onKernelRequest(GetResponseEvent $e)
    {

        if (HttpKernelInterface::MASTER_REQUEST !== $e->getRequestType()) {
            return;
        }

        $request = $e->getRequest();

        $cookie = $this->getCookie($request);

        if (empty($cookie['latitude']) || empty($cookie['longitude'])) {
            $cookie = $this->getLatitudeLongitude($request, $cookie);
        }

        $this->setRequestAttributes($cookie, $request);
    }

    public function onKernelResponse(FilterResponseEvent $e)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $e->getRequestType()) {
            return;
        }

        $response = $e->getResponse();
        $request  = $e->getRequest();

        /** @var Point $localisation */
        $localisation = $request->attributes->get('phil.geolocation.localisation.full');

        if ($localisation) {
            $cookieData = array(
                'latitude'  => $localisation->getLatitude(),
                'longitude' => $localisation->getLongitude(),
                'geotype'   => $request->attributes->get('phil.geolocation.geotype'),
                'cityname'  => $request->attributes->get('phil.geolocation.cityname')
            );
            $cookie     = new Cookie(self::COOKIE_NAME, json_encode($cookieData), 0, '/', null, false, false);
            $response->headers->setCookie($cookie);
        }
    }

    /**
     * @param $cookie
     * @param $request
     */
    private function setRequestAttributes($cookie, Request $request)
    {
        $fullLocalisation  = new Point(array($cookie['latitude'], $cookie['longitude']));
        $shortLocalisation = new Point(array(round($cookie['latitude'], 3), round($cookie['longitude'], 3)));

        $request->attributes->set('phil.geolocation.localisation.full', $fullLocalisation);
        $request->attributes->set('phil.geolocation.localisation.short', $shortLocalisation);
        $request->attributes->set('phil.geolocation.geotype', $cookie['geotype']);
        $request->attributes->set('phil.geolocation.cityname', $cookie['cityname']);

        $geolocation = array('geotype' => $cookie['geotype'], 'cityname' => $cookie['cityname'],
                             'localisation' => array('full' => $fullLocalisation, 'short' => $shortLocalisation));
        $request->getSession()->set('phil.geolocation', $geolocation);
    }

    /**
     * @param $request
     * @param $cookie
     *
     * @return mixed
     */
    private function getLatitudeLongitude(Request $request, $cookie)
    {
        try {
            $coords = $this->geocoder->geocode($request->getClientIp());
        } catch (\Exception $e) {
            $coords = $this->getDefaultCoords();
        }

        if ($coords['latitude'] == 0 || $coords['longitude']) {
            $coords = $this->getDefaultCoords();
        }


        $cookie['latitude']  = $coords['latitude'];
        $cookie['longitude'] = $coords['longitude'];
        $cookie['geotype'] = 'ip';
        $cookie['cityname'] = null;

        return $cookie;
    }

    /**
     * @param $request
     *
     * @return array|mixed
     */
    private function getCookie($request)
    {
        if ($request->cookies->has(self::COOKIE_NAME)) {
            $cookie = $request->cookies->get(self::COOKIE_NAME);
            $cookie = json_decode($cookie, true);

            return $cookie;
        } else {
            $cookie = array('latitude' => null, 'longitude' => null, 'geotype' => 'ip', 'cityname' => null);

            return $cookie;
        }
    }

    /**
     * @return array
     */
    private function getDefaultCoords()
    {
        $coords = array(
            'latitude'  => "43.650297000",
            'longitude' => "-79.385298000"
        );

        return $coords;
    }
} 