<?php

namespace Mateu\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Group\Domain\Entity\Group;
use Mateu\Backend\InType\Domain\Entity\InType;
use Mateu\Backend\Purchaser\Domain\Entity\Purchaser;
use Mateu\Backend\Race\Domain\Entity\Race;
use Mateu\Backend\Register\Domain\Entity\Register;
use Mateu\Backend\Supplier\Domain\Entity\Supplier;
use Mateu\Backend\User\Domain\Entity\User;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BaseFixtures extends Fixture implements FixtureInterface
{
    public const USER_REFERENCE = 'user';

    private const USERS = [
        [
            'username' => 'alex_beis',
            'email' => 'admin@admin.com',
            'password' => 'admin123',
            'fullName' => 'Alex Beis',
            'roles' => [User::ROLE_ADMIN]
        ],
        [
            'username' => 'rob_smith',
            'email' => 'rob_smith@smith.com',
            'password' => 'rob12345',
            'fullName' => 'Rob Smith',
            'roles' => [User::ROLE_USER]
        ],
        [
            'username' => 'marry_gold',
            'email' => 'marry_gold@gold.com',
            'password' => 'marry12345',
            'fullName' => 'Marry Gold',
            'roles' => [User::ROLE_USER]
        ],
    ];

    private const NAMES_TEXT = [
        'Julia Trillo',
        'Gloria Trillo',
        'Ana 1',
        'Ana 2',
        'Mateu 1',
        'Berta',
        'Loles',
        'Aloha',
        'Angel'
    ];

    private const LOCATIONS = [
        'Marruecos',
        'Galicia',
        'Binefar',
        'Asturias',
        'Santander'
    ];

    private const SUPPLIERS = [
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

    private const RACES = [
        ['code' => '0001', 'name' => 'raza1'],
        ['code' => '0002', 'name' => 'raza2'],
        ['code' => '0003', 'name' => 'raza3']
    ];

    private const INTYPES = [
      ['code' => '001', 'name' => 'Nacimiento'],
      ['code' => '002', 'name' => 'Compra'],
      ['code' => '003', 'name' => 'Translado'],
      ['code' => '004', 'name' => 'Otro']
    ];

    private const GROUPS = [
      ['code' => 'G001', 'name' => 'Grupo1'],
      ['code' => 'G002', 'name' => 'Grupo2'],
      ['code' => 'G003', 'name' => 'Grupo3']
    ];

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadInTypes($manager);
        $this->loadGroups($manager);
        $this->loadRaces($manager);
        $this->loadExplotations($manager);
        $this->loadSuppliers($manager);
        //$this->loadAnimals($manager);
        $this->loadRegisters($manager);
        $this->loadPurchasers($manager);
        //$this->loadOutTypes($manager);

    }

    private function loadUsers(ObjectManager $manager)
    {
        foreach (self::USERS as $userData) {

            $user = new User();
            $user->setFullName($userData['fullName']);
            $user->setEmail($userData['email']);
            $user->setUsername($userData['username']);
            $user->setPassword($this->userPasswordEncoder
                ->encodePassword(
                    $user,
                    $userData['password'])
            );
            $user->setRoles($userData['roles']);

            $this->addReference($userData['username'], $user);

            $manager->persist($user);
        }
        $manager->flush();

    }

    private function loadExplotations(ObjectManager $manager)
    {
        $explotations = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];

        foreach (self::NAMES_TEXT as $key => $explotation) {
            $e = new Explotation();
            $e->setCode('EXPL_' . $key);
            $e->setLocalization(uniqid('LOC_'));
            $e->setName($explotation);
            $e->setCreatedBy(
                $this->getReference(
                    self::USERS[rand(0, count(self::USERS) - 1)] ['username']
                )
            );
            $date = new \DateTime();
            $date->modify('-' . rand(0, 10) . 'day');
            $e->setCreatedAt($date);
            $e->setGroup($this->getReference(self::GROUPS[rand(0, count(self::GROUPS) - 1)]['name']));

            $this->addReference($explotation, $e);
            $manager->persist($e);
        }

        $manager->flush();

    }

    private function loadInTypes(ObjectManager $manager)
    {
        foreach (self::INTYPES as $inType) {
            $t = InType::create(Uuid::random()->getValue(), $inType['code'], $inType['name']);
            $this->addReference($inType['name'], $t);

            $manager->persist($t);
        }

        $manager->flush();
    }

    private function loadGroups(ObjectManager $manager)
    {
        foreach (self::GROUPS as $group) {
            $g = Group::create($group['code'], $group['name']);
            $this->addReference($group['name'], $g);

            $manager->persist($g);
        }

        $manager->flush();
    }

    private function loadRegisters(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $procedence = self::LOCATIONS[rand(0, count(self::LOCATIONS) - 1)];
            $supplier = $this->getReference(self::SUPPLIERS[rand(0, count(self::SUPPLIERS) - 1)]['companyName']);
            $inType = $this->getReference(self::INTYPES[rand(0, count(self::INTYPES) - 1)]['name']);

            $explotation = $this->getReference(self::NAMES_TEXT[rand(0, count(self::NAMES_TEXT) - 1)]);
            $race = $this->getReference(self::RACES[rand(0, count(self::RACES) - 1)]['code']);
            $register = (new Register())
                ->setProcedence($procedence)
                ->setInType($inType)
                ->setSupplier($supplier);

            for ($j = 0; $j < rand(10,30); $j++) {
                $animal = new Animal();
                $crot = (string)rand(1000000000, 9999999999);
                $crotMother = (string)rand(1000000000, 9999999999);
                $num = substr($crot, -4);
                $animal->setInternalNum($num);
                $animal->setCrotal($crot);
                $animal->setCrotalMother($crotMother);
                $animal->setWeightIn(rand(10, 20));
                $date = new \DateTime();
                $date->modify('-' . rand(0, 10) . 'day');
                $animal->setBirthDate($date);
                $animal->setExplotation($explotation);
                $genere = ($i%2 == 0)? 'Male':'Female';
                $animal->setGenre($genere);
                $animal->setRace($race);

                $register->addAnimal($animal);
            }
            $manager->persist($register);
            $manager->flush();
        }

    }

    private function loadAnimals(ObjectManager $manager)
    {
        for ($i = 0; $i < 500; $i++) {
            $animal = new Animal();
            $crot = (string)rand(1000000000, 9999999999);
            $crotMother = (string)rand(1000000000, 9999999999);
            $num = substr($crot, -4);
            $animal->setInternalNum($num);
            $animal->setCrotal($crot);
            $animal->setCrotalMother($crotMother);
            //$animal->setProcedence(self::LOCATIONS[rand(0, count(self::LOCATIONS) - 1)]);
            $animal->setWeightIn(rand(10, 20));
            $date = new \DateTime();
            $date->modify('-' . rand(0, 10) . 'day');
            $animal->setBirthDate($date);
            $animal->setExplotation($this->getReference(self::NAMES_TEXT[rand(0, count(self::NAMES_TEXT) - 1)]));
            $genere = ($i%2 == 0)? 'Male':'Female';
            $animal->setGenre($genere);
            $animal->setRace($this->getReference(self::RACES[rand(0, count(self::RACES) - 1)]['code']));
            //$animal->setInType($this->getReference(self::INTYPES[rand(0, count(self::INTYPES) - 1)]['name']));

            $manager->persist($animal);
            if ($i % 50 == 0) {
                $manager->flush();
            }

        }
        $manager->flush();

    }

    public function loadRaces(ObjectManager $manager)
    {
        foreach (self::RACES as $key => $race) {
            $r = new Race(Uuid::random()->getValue(),$race['code'], $race['name']);
            $this->addReference($race['code'], $r);
            $manager->persist($r);
        }

        $manager->flush();


    }

    private function loadSuppliers(ObjectManager $manager)
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

    private function loadPurchasers(ObjectManager $manager)
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