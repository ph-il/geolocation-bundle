<?php
namespace Phil\GeolocationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Phil\GeolocationBundle\Entity\PostalCode;
use Phil\GeolocationBundle\ORM\Point;

abstract class loadPostalCodeData extends AbstractFixture implements FixtureInterface {

    const FORMAT_CSV = 'csv';
    const FORMAT_GEONAMES = 'geoname';
    const BATCH_SIZE = 1000;

    protected $entriesAdded = 0;
    protected $repo;

    protected function getRepository(ObjectManager $manager) {
        return $manager->getRepository(get_class(new PostalCode()));
    }

    protected function clearPostalCodesTable(ObjectManager $manager) {
        foreach ($this->getRepository($manager)->findAll() as $entity) {
            $manager->remove($entity);
        }
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param string $filename
     * @param string $format
     * @return integer Number of entries actually added.
     */
    protected function addEntries(ObjectManager $manager, $filename, $format = self::FORMAT_GEONAMES) {
        $this->prepareRepo($manager);

        switch($format) {
            case self::FORMAT_GEONAMES:
                $this->addEntriesFromGeoName($manager, $filename);
                break;
            case self::FORMAT_CSV:
                $this->addEntriesFromCSV($manager, $filename);
                break;
            default:
                throw new \InvalidArgumentException();
        }

        echo ' ', $this->entriesAdded, "\n";

        return $this->entriesAdded;
    }

    /**
     * @param $country
     * @param $postalCode
     * @param $currentBatchEntries
     * @param $repo
     *
     * @return bool
     */
    private function checkDuplicate($country, $postalCode, $currentBatchEntries)
    {
        // skip duplicate entries in current batch
        if (in_array($country . '-' . $postalCode, $currentBatchEntries)) {
            return true;
        }

        // skip duplicate entries already persisted
        if ($this->repo->findOneBy(array('country' => $country, 'postalCode' => $postalCode)) !== null) {
            return true;
        }

        return false;
    }

    /**
     * @param ObjectManager $manager
     * @param               $country
     * @param               $postalCode
     * @param               $arr
     */
    private function addPostalCode(ObjectManager $manager, $country, $postalCode, $latitude, $longitude)
    {
        $entity = new PostalCode();
        $entity->setCountry($country);
        $entity->setPostalCode($postalCode);
        $entity->setLatitudeLongitude(new Point(array((float) $latitude, (float) $longitude)));
        $manager->persist($entity);
        ++$this->entriesAdded;

        $this->addReference('postalcode-' . $this->entriesAdded, $entity);

    }

    /**
     * @param ObjectManager $manager
     */
    protected function prepareRepo(ObjectManager $manager)
    {
        if (is_null($this->repo)) {
            $this->repo = $this->getRepository($manager);
        }
    }

    /**
     * @param ObjectManager $manager
     * @param               $filename
     */
    private function addEntriesFromGeoName(ObjectManager $manager, $filename)
    {
        $currentBatchEntries = array();

        $fcontents = file($filename);
        for ($i = 0, $numLines = count($fcontents); $i < $numLines; ++$i) {
            $line = trim($fcontents[$i]);
            $arr  = explode("\t", $line);

            // skip if no lat/lng values
            if (!array_key_exists(9, $arr) || !array_key_exists(10, $arr)) {
                continue;
            }

            $country    = $arr[0];
            $postalCode = $arr[1];

            if ($this->checkDuplicate($country, $postalCode, $currentBatchEntries)) {
                continue;
            }

            $this->addPostalCode($manager, $country, $postalCode, (float)$arr[9], (float)$arr[10]);

            $currentBatchEntries[] = $country . '-' . $postalCode;

            if ((($i + 1) % self::BATCH_SIZE) === 0) {
                $manager->flush();
                $manager->clear();
                $currentBatchEntries = array();
                echo '.'; // progress indicator
            }
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param               $filename
     */
    private function addEntriesFromCSV(ObjectManager $manager, $filename)
    {
        $currentBatchEntries = array();

        if (($handle = fopen("$filename", "r")) !== FALSE) {

            $i = 0;
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if (!array_key_exists(2, $data) || !array_key_exists(3, $data)) {
                    continue;
                }

                $country    = $data[0];
                $postalCode = $data[1];

                if ($this->checkDuplicate($country, $postalCode, $currentBatchEntries)) {
                    continue;
                }

                $this->addPostalCode($manager, $country, $postalCode, (float) $data[2], (float) $data[3]);

                $currentBatchEntries[] = $country . '-' . $postalCode;

                if ((($i + 1) % self::BATCH_SIZE) === 0) {
                    $manager->flush();
                    $manager->clear();
                    $currentBatchEntries = array();
                    echo '.'; // progress indicator
                }
            }
            fclose($handle);
            $manager->flush();
        }
    }
}
