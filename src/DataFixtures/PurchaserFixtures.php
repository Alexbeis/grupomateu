<?php

namespace Mateu\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mateu\Backend\Purchaser\Domain\Entity\Purchaser;

class PurchaserFixtures extends Fixture implements FixtureInterface
{
    private const PURCHASERS = [
        [
            'companyName' => 'PURCHASER_1',
            'contactName' => 'Mohamed 5',
            'address' => 'calle pepito , 113 2o D',
            'email' => 'me@supplier1.com',
            'city' => 'Tanger',
            'region' => 'Tanger',
            'postalCode' => '082028',
            'country' => 'Morroco',
            'phone' => '3423432432',
            'mobilePhone' => '342342423424',
            'fax' => '3364564564',
            'website' => 'http://example.com'
        ], [
            'companyName' => 'PURCHASER_2',
            'contactName' => 'Fribin',
            'address' => 'calle pepito , 113 2o D',
            'email' => 'me@purchaser22.com',
            'city' => 'Madrid',
            'region' => 'Madrid',
            'postalCode' => '082028',
            'country' => 'Spain',
            'phone' => '3423432432',
            'mobilePhone' => '76756766767',
            'fax' => '3364564564',
            'website' => 'http://www.supllier2.com'
        ], [
            'companyName' => 'PURCHASER_3',
            'contactName' => 'Campofrio',
            'address' => 'calle mi casa , 113 2o D',
            'email' => 'me@purchaser3.com',
            'city' => 'Santander',
            'region' => 'Cantabria',
            'postalCode' => '082028',
            'country' => 'Spain',
            'phone' => '342343762432',
            'mobilePhone' => '6565656665',
            'fax' => '3364564564',
            'website' => 'http://www.supplier3.com'
        ],

    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::PURCHASERS as $purchaserData) {

            $purchaser = new Purchaser();
            $purchaser->setCompanyName($purchaserData['companyName']);
            $purchaser->setContactName($purchaserData['contactName']);
            $purchaser->setAddress($purchaserData['address']);
            $purchaser->setEmail($purchaserData['email']);
            $purchaser->setCity($purchaserData['city']);
            $purchaser->setCountry($purchaserData['country']);
            $purchaser->setRegion($purchaserData['region']);
            $purchaser->setPostalCode($purchaserData['postalCode']);
            $purchaser->setFax($purchaserData['fax']);
            $purchaser->setPhone($purchaserData['phone']);
            $purchaser->setMobilePhone($purchaserData['mobilePhone']);
            $purchaser->setWebsite($purchaserData['mobilePhone']);
            $date = new \DateTime();
            $date->modify('-' . rand(0, 10) . 'day');
            $purchaser->setCreatedAt($date);
            $manager->persist($purchaser);
        }

        $manager->flush();
    }
}