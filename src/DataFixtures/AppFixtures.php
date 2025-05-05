<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\ClientFactory;
use App\Factory\ChambreFactory;
use App\Factory\HotelFactory;
use App\Factory\ReservationFactory;
use App\Factory\UserFactory;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
       
        ChambreFactory::createMany(3);
        HotelFactory::createMany(3);
        ReservationFactory::createMany(3);
        UserFactory::createMany(5);
ClientFactory::createMany(5);
    }
}
