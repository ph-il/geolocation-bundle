Phil GeolocationBundle
======================

A Symfony2 Bundle to handle geographic location. Add geolocation to your entities. Add address entities. Add user geo location. Add doctrine functions for calculating geographical distances in your project.

[![Latest Stable Version](https://poser.pugx.org/phil/geolocation-bundle/v/stable.png)](https://packagist.org/packages/phil/geolocation-bundle)
[![Total Downloads](https://poser.pugx.org/phil/geolocation-bundle/downloads.png)](https://packagist.org/packages/phil/geolocation-bundle)
[![License](https://poser.pugx.org/phil/geolocation-bundle/license.png)](https://packagist.org/packages/phil/geolocation-bundle)
[![Build Status](https://travis-ci.org/ph-il/geolocation-bundle.png?branch=master)](https://travis-ci.org/ph-il/geolocation-bundle)
[![Coverage Status](https://coveralls.io/repos/ph-il/geolocation-bundle/badge.png)](https://coveralls.io/r/ph-il/geolocation-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/fb3d1e33-4c3a-4ace-bbfb-2ab191f9144b/mini.png)](https://insight.sensiolabs.com/projects/fb3d1e33-4c3a-4ace-bbfb-2ab191f9144b)

# 1 Installation #

## 1.1 Composer ##


    ```
	"require": {
		....
		"phil/geolocation-bundle": "~0.2"
	},
    ```

or

    ```
    php composer.phar require phil/geolocation-bundle
    ```


## 1.2 Enable the bundle ##

    ```php
	// app/AppKernel.php
	public function registerBundles()
	{
        $bundles = array(
	        // ...
	        new Phil\GeolocationBundle\PhilGeolocationBundle(),
	    );
	}
    ```
## 1.3 Register the Doctrine functions you need ##

You need to manually register the Doctrine functions you want to use.
See http://symfony.com/doc/current/cookbook/doctrine/custom_dql_functions.html for details.

    ```yaml
    # in app/config/config.yml

    doctrine:
        dbal:
            types:
                point: Phil\GeolocationBundle\ORM\PointType
            connections:
                default:
                    mapping_types: { point: point }
        orm:
            dql:
                numeric_functions:
                    POINTSTR: Phil\GeolocationBundle\ORM\PointStr
                    DISTANCE: Phil\GeolocationBundle\ORM\Distance
    ```

## 1.4 Update Your schema ##

    doctrine:schema:update

# 2 Usage #

## 2.1 Entities ##

You can create a relation to one of the Entities, or you can use one of the traits. You can use interfaces, you need
AddressInterface and GeocodeInterface. AddressableEntity and GeocodableEntity are the traits for those interface.

Address is independent of any other entities.

## 2.2 Formatter ##

    ```php
	$formatted = $this->get("padam87.address.formatter")->format($address);

### Flags ###

    ```php
	use Phil\GeolocationBundle\Service\FormatterService;

	...

	$formatted = $this->get("phil.geolocation.address.formatter")->format($address, FormatterService::FLAG_NOBR);
    ```

### Available flags ###

`FLAG_NOBR` No linebreak will be added

`FLAG_HTML` Outputs the address in html format

`FLAG_NOCASE` No case change will be applied

### 2.3 Twig extension ###

	{{ address|address()|raw }}

This will output the formatted address, with the `FLAG_HTML` added by default

## 2.4 Geocoding ##

    ```php
	use Phil\GeolocationBundle\Entity\Address;

	...

	$address = new Address();
    ```

The listener will take care of the rest ;). If you're using you own entity (without using traits) you'll need those two
interfaces: AddressInterface and GeocodeInterface.

## 2.5 Import geographical data ##

This is probably the most annoying step: Storing all geographical data with their geographical positions for the countries
you need. Fortunately, it's not that hard to get this information and import it into your database.

### For Postal Code By Country (data from geonames.org)

Go to http://download.geonames.org/export/zip/ and download the archives for the countries you need. Let's just take
`DE.zip`. Unzip the included `DE.txt` file, e.g. to `/tmp/DE.txt`.

Create a fixture class (in a separate folder to be able to load only this one) which extends the provided base class:

```php
// MyCompany/MyBundle/Doctrine/Fixtures/PhilGeolocation/MyGeonamesPostalCodeData.php
namespace MyCompany\MyBundle\Doctrine\Fixtures\PhilGeolocation;

use Phil\GeolocationBundle\DataFixtures\ORM\loadPostalCodeData;
use Doctrine\Common\Persistence\ObjectManager;

class MyGeonamesPostalCodeData extends loadPostalCodeData {

	public function load(ObjectManager $manager) {
		$this->clearPostalCodesTable($manager);
		$this->addEntries($manager, '/tmp/DE.txt', loadPostalCodeData::FORMAT_GEONAMES);
	}

}
```

### For Postal Code By Country (your own data : example available in DataFixtures/data)


Create a fixture class (in a separate folder to be able to load only this one) which extends the provided base class:

```php
// MyCompany/MyBundle/Doctrine/Fixtures/PhilGeolocation/MyGeonamesPostalCodeData.php
namespace MyCompany\MyBundle\Doctrine\Fixtures;

use Phil\GeolocationBundle\DataFixtures\ORM\loadPostalCodeData;
use Doctrine\Common\Persistence\ObjectManager;

class MyGeonamesPostalCodeData extends loadPostalCodeData {

	public function load(ObjectManager $manager) {
		$this->clearPostalCodesTable($manager);
		$this->addEntries($manager, '/tmp/postalcode.csv', loadPostalCodeData::FORMAT_CSV);
	}

}
```

Now, backup your database! Don't blame anyone else for data loss if something goes wrong.
Then import the fixture and remember to use the `--append` parameter.

```sh
# in a shell
php app/console doctrine:fixtures:load --append --fixtures="src/MyCompany/MyBundle/DataFixtures/ORM"
```

sf doctrine:fixtures:load --append --fixtures="src/Phil/TestBundle/DataFixtures/ORM"

# 3 Thanks #

Some idea are taken from
[padam87/address-bundle](https://packagist.org/packages/padam87/address-bundle)
[craue/geo-bundle](https://github.com/craue/CraueGeoBundle)

# 4 TODO #
There is a lot to do :
* Finish all testing
* More documentations
* Clean Up Code
* All all require Entities for Geolocation

Fill free to send some corrections and suggestions.


