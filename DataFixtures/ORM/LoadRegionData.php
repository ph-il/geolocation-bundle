<?php

namespace Phil\GeolocationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Phil\GeolocationBundle\Entity\Region;
use Phil\GeolocationBundle\ORM\Point;

class LoadRegionData extends AbstractFixture implements OrderedFixtureInterface
{

  public function load(ObjectManager $manager)
  {
    $this->manager = $manager;
    
    $this->addRegion('Îles-de-la-Madeleine', '47.3896263', '-61.9114214', 'region-1');
    $this->addRegion('Gaspésie', '48.902945', '-64.478683', 'region-2');
    $this->addRegion('Bas-Saint-Laurent', '47.835877', '-69.536136', 'region-3');
    $this->addRegion('Région de Québec', '46.8032826', '-71.242796', 'region-4');
    $this->addRegion('Charlevoix', '47.6304216', '-70.6482074', 'region-5');
    $this->addRegion('Chaudière-Appalaches', '46.9666667', '-70.55', 'region-6');
    $this->addRegion('Mauricie', '46.393107', '-72.664693', 'region-7');
    $this->addRegion('Cantons-de-l\'Est', '45.2650549', '-72.146745', 'region-8');
    $this->addRegion('Montérégie', '45.537405', '-73.510726', 'region-9');
    $this->addRegion('Lanaudière', '46.023222', '-73.439239', 'region-10');
    $this->addRegion('Laurentides', '45.65', '-74.1', 'region-11');
    $this->addRegion('Montréal', '45.5088889', '-73.5541667', 'region-12');
    $this->addRegion('Outaouais', '45.483933', '-75.645632', 'region-13');
    $this->addRegion('Abitibi-Témiscamingue', '48.581999', '-78.108601', 'region-14');
    $this->addRegion('Saguenay–Lac-Saint-Jean', '48.429876', '-71.053647', 'region-15');
    $this->addRegion('Manicouagan', '50.64941', '-68.752037', 'region-16');
    $this->addRegion('Duplessis', '47.7', '-73.216667', 'region-17');
    $this->addRegion('Nord-du-Québec', '52.9399159', '-73.5491361', 'region-18');
    $this->addRegion('Laval', '45.577524', '-73.744965', 'region-19');
    $this->addRegion('Centre-du-Québec', '45.881325', '-72.500447', 'region-20');
  }

  private function addRegion($name, $lat, $long, $id)
  {
    $region = new Region();
    $region->setName($name);
    $region->setLatitudeLongitude(new Point(array($lat, $long)));

    $this->manager->persist($region);
    $this->manager->flush();

    $this->addReference($id, $region);
  }

  public function getOrder()
  {
    return 10; // the order in which fixtures will be loaded
  }

}