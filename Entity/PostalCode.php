<?php

namespace Phil\GeolocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Phil\GeolocationBundle\ORM\Point;
use Phil\GeolocationBundle\Traits\GeocodableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Region
 *
 * @author Philippe Gamache
 *
 * @ORM\Entity
 * @ORM\Table(name="geo_postalcode",
 * 	uniqueConstraints={@ORM\UniqueConstraint(name="postal_code_idx", columns={
 * 		"country", "postal_code"
 * 	})}
 * )
 *
 *
 */
class PostalCode
{
    use BlameableEntity;
    use TimestampableEntity;
    use GeocodableEntity;

    /**
     * @orm\Id
     * @orm\Column(type="integer")
     * @orm\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="country", type="string", length=2, nullable=false)
     * @Assert\NotBlank
     */
    protected $country;
    /**
     * @orm\Column(name="postal_code", type="string", length=20)
     * @Assert\Length(max=20)
     */
    protected $postalCode;
    /**
     * @orm\Column(type="string", length=25, unique=true)
     * @Gedmo\Slug(fields={"country", "postalCode"})
     */
    protected $slug;

    /**
     *
     */
    public function __construct()
    {
        $this->latitudeLongitude = new Point(array(0, 0));
    }

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
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
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

}
