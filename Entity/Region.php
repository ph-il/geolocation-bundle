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
 * @orm\Entity
 * @orm\Table(name="geo_region")
 *
 */
class Region
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
     * @orm\Column(type="string", length="100")
     * @Assert\Length(max="100")
     * @Gedmo\Sluggable()
     */
    protected $name;

    /**
     * @orm\Column(type="string", length="105", unique=true)
     * @Gedmo\Slug()
     */
    protected $slug;

    /**
     *
     */
    public function __construct()
    {
        $this->latitudeLongitude = new Point(array(0, 0));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }
}
