<?php

namespace Phil\GeolocationBundle\Traits;

/**
 * Description of Address
 *
 * @author  Philippe Gamache
 * @package Phil\GeolocationBundle\Traits
 */

trait AddressableEntity
{

    /**
     * Country name
     *
     * microformat 2 : p-country-name in h-adr
     *
     * @ORM\Column(type="string", length=100, name="country")
     *
     * @Assert\Country()
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     * #Gedmo\Versioned
     *
     * @var string
     */
    protected $country;

    /**
     * Postal code, e.g. ZIP in the US
     *
     * microformat 2 : p-postal-code in h-adr
     *
     * @var string
     *
     * @ORM\Column(type="string", length=10, name="postal_code", nullable=true)
     *
     * @Assert\Length(min=2, max=10)
     * #Gedmo\Versioned
     */
    protected $postalCode;

    /**
     * Province/state/county
     *
     * microformat 2 : p-region in h-adr
     *
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Assert\Length(min=2, max=100)
     * #Gedmo\Versioned
     */
    protected $region;

    /**
     * County/administrative division
     *
     * microformat 2 : n/a
     *
     * @var string
     *
     * @ORM\Column(type="string", length=100, name="sub_region", nullable=true)
     *
     * @Assert\Length(min=2, max=100)
     * #Gedmo\Versioned
     */
    protected $subRegion;

    /**
     * City/town/village
     *
     * microformat 2 : p-locality in h-adr
     *
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Assert\Length(max=100)
     * #Gedmo\Versioned
     */
    protected $locality;

    /**
     * District
     *
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max=100)
     */
    protected $district;

    /**
     * House/apartment number, floor, street name
     *
     * microformat 2 : p-street-address in h-adr
     *
     * @var string
     *
     * @ORM\Column(type="string", length=200, name="street_address", nullable=true)
     *
     * @Assert\Length(min=3, max=200)
     * #Gedmo\Versioned
     */
    protected $streetAddress;

    /**
     * Additional street details
     *
     * @var string
     *
     * @ORM\Column(type="string", length=200, name="extended_address", nullable=true)
     *
     * @Assert\Length(min=3, max=200)
     * #Gedmo\Versioned
     */
    protected $extendedAddress;

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @param $district
     *
     * @return $this
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtendedAddress()
    {
        return $this->extendedAddress;
    }

    /**
     * @param $extendedAddress
     *
     * @return $this
     */
    public function setExtendedAddress($extendedAddress)
    {
        $this->extendedAddress = $extendedAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * @param $locality
     *
     * @return $this
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param $postalCode
     *
     * @return $this
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param $region
     *
     * @return $this
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * @param $streetAddress
     *
     * @return $this
     */
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubRegion()
    {
        return $this->subRegion;
    }

    /**
     * @param $subRegion
     *
     * @return $this
     */
    public function setSubRegion($subRegion)
    {
        $this->subRegion = $subRegion;

        return $this;
    }

}