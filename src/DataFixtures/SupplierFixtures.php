<?php

namespace Mateu\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mateu\Backend\Supplier\Domain\Entity\Supplier;

class SupplierFixtures extends Fixture implements FixtureInterface
{
    public const SUPPLIERS = [
        [
            'companyName' => 'SUPPLIER_1',
            'contactName' => 'Alberto Mamadou',
            'address' => 'calle pepito , 113 2o D',
            'email' => 'me@supplier1.com',
            'city' => 'Barcelona',
            'region' => 'Barcelona',
            'postalCode' => '082028',
            'country' => 'Spain',
            'phone' => '3423432432',
            'mobilePhone' => '342342423424',
            'fax' => '3364564564',
            'website' => 'http://example.com'
        ], [
            'companyName' => 'SUPPLIER_2',
            'contactName' => 'Jesus Gil',
            'address' => 'calle pepito , 113 2o D',
            'email' => 'me@supplier2.com',
            'city' => 'Madrid',
            'region' => 'Madrid',
            'postalCode' => '082028',
            'country' => 'Spain',
            'phone' => '3423432432',
            'mobilePhone' => '76756766767',
            'fax' => '3364564564',
            'website' => 'http://www.supllier2.com'
        ], [
            'companyName' => 'SUPPLIER_3',
            'contactName' => 'Albert PLa',
            'address' => 'calle mi casa , 113 2o D',
            'email' => 'me@supplier3.com',
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
        foreach (self::SUPPLIERS as $supplierData) {
            $supplier = new Supplier();
            $supplier->setCompanyName($supplierData['companyName']);
            $supplier->setContactName($supplierData['contactName']);
            $supplier->setAddress($supplierData['address']);
            $supplier->setEmail($supplierData['email']);
            $supplier->setCity($supplierData['city']);
            $supplier->setCountry($supplierData['country']);
            $supplier->setRegion($supplierData['region']);
            $supplier->setPostalCode($supplierData['postalCode']);
            $supplier->setFax($supplierData['fax']);
            $supplier->setPhone($supplierData['phone']);
            $supplier->setMobilePhone($supplierData['mobilePhone']);
            $supplier->setWebsite($supplierData['website']);
            $date = new \DateTime();
            $date->modify('-' . rand(0, 10) . 'day');
            $supplier->setCreatedAt($date);

            $manager->persist($supplier);
            $this->addReference($supplierData['companyName'], $supplier);
        }

        $manager->flush();
    }
}