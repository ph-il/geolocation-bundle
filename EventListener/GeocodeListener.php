<?php

namespace Phil\GeolocationBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Phil\GeolocationBundle\Entity\GeocodeInterface;
use Phil\GeolocationBundle\Service\GeocoderService;

class GeocodeListener
{
    /**
     * @var GeocoderService
     */
    private $geocoder;

    /**
     * @param GeocoderService $geocoder
     */
    public function __construct(GeocoderService $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->geocode($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $this->geocode($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    protected  function geocode(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof GeocodeInterface && $entity instanceof GeocodeInterface) {
            $this->geocoder->geocode($entity);
        }
    }
}
