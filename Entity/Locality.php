<?php

namespace Phil\GeolocationBundle\Entity;

use Doctrine\ORM\Mapping as orm;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Phil\GeolocationBundle\ORM\Point;
use Phil\GeolocationBundle\Traits\GeocodableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Locality
 *
 * @author Philippe Gamache
 *
 * @ORM\Entity
 * @ORM\Table(name="geo_locality",
 * 	uniqueConstraints={@ORM\UniqueConstraint(name="locality_idx", columns={
 * 		"country", "region", "name"
 * 	})}
 * )
 *
 */
class Locality
{
    use BlameableEntity;
    use TimestampableEntity;
    use GeocodableEntity;

    /**
     * @var integer
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
     * @var string
     * @ORM\Column(name="region", type="string", length=2, nullable=false)
     * @Assert\NotBlank
     */
    protected $region;
    /**
     * @var string
     * @ORM\Column(name="sub_region", type="string", length=100, nullable=true)
     */
    protected $subRegion;
    /**
     * @var string
     * @orm\Column(type="string", length=100)
     * @Assert\Length(max=100)
     */
    protected $name;
    /**
     * @var string
     * @orm\Column(type="string", length=120, unique=true)
     * @Gedmo\Slug(fields={"name", "region", "country"})
     */
    protected $slug;

    /**
     * @var string
     * @orm\Column(type="string", length=15, unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    protected $slugName;

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
    public function getSubRegion()
    {
        return $this->subRegion;
    }

    /**
     * @param $subRegion
     *
     * @return $this
     */
    public function setSubregion($subRegion)
    {
        $this->subRegion = $subRegion;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
