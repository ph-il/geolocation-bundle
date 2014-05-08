<?php

namespace Phil\GeolocationBundle\Traits;

use Phil\GeolocationBundle\Entity\AddressInterface;

/**
 * Adds a single address to the given Entity (one-to-one unidiretional)
 */
trait SingleAddressTrait
{
    /**
     * @var AddressInterface
     *
     * @ORM\OneToOne(targetEntity="Phil\GeolocationBundle\Entity\Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="address_id", referencedColumnName="id")
     * @Assert\Valid()
     */
    private $address;

    /**
     * @return AddressInterface
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param AddressInterface $address
     *
     * @return $this
     */
    public function setAddress(AddressInterface $address = null)
    {
        $this->address = $address;

        return $this;
    }
}