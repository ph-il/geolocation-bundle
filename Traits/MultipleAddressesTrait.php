<?php

namespace Phil\GeolocationBundle\Traits;

use Phil\GeolocationBundle\Entity\AddressInterface;

/**
 * Adds multiple addresses to the given Entity (many-to-many unidirectional)
 */
trait MultipleAddressesTrait
{
    /**
     * @var \Doctrine\Common\Collections\Collection[AddressInterface]
     *
     * @ORM\ManyToMany(targetEntity="Phil\GeolocationBundle\Entity\Address")
     * @Assert\Valid()
     */
    private $addresses;

    /**
     * @param AddressInterface $addresses
     *
     * @return $this
     */
    public function addAddress(AddressInterface $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * @param AddressInterface $addresses
     */
    public function removeAddress(AddressInterface $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
}