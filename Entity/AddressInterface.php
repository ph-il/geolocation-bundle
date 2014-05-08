<?php

namespace Phil\GeolocationBundle\Entity;

interface AddressInterface
{
    /**
     * @return string
     */
    public function getCountry();

    /**
     * @return string
     */
    public function getPostalCode();

    /**
     * @return string
     */
    public function getRegion();

    /**
     * @return string
     */
    public function getSubRegion();

    /**
     * @return string
     */
    public function getLocality();

    /**
     * @return string
     */
    public function getDistrict();

    /**
     * @return string
     */
    public function getStreetAddress();

    /**
     * @return string
     */
    public function getExtendedAddress();
}