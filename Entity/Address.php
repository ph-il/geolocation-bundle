<?php

namespace Phil\GeolocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Phil\GeolocationBundle\ORM\Point;
use Phil\GeolocationBundle\Traits\AddressableEntity;
use Phil\GeolocationBundle\Traits\GeocodableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Address
 *
 * @author Philippe Gamache
 *
 * @ORM\Entity
 * @ORM\Table(name="geo_address")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 */
class Address implements AddressInterface, GeocodeInterface
{
    use BlameableEntity;
    use TimestampableEntity;
    use AddressableEntity;
    use GeocodableEntity;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     */
    public function __construct()
    {
        $this->latitudeLongitude = new Point(array(0, 0));
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


}

