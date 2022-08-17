<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Producer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordEncoderInterface)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $producer = new Producer();
        $producer->setPassword($this->userPasswordEncoderInterface->hashPassword($producer, "password"));
        $producer->setLastName("Kokora");
        $producer->setFirstName("DJEGBA");
        $producer->setEmail("producer@gmail.com");
        $manager->persist($producer);

        $customer = new Customer();
        $customer->setPassword($this->userPasswordEncoderInterface->hashPassword($customer, "password"));
        $customer->setLastName("Christian");
        $customer->setFirstName("JEAN");
        $customer->setEmail("customer@gmail.com");
        $manager->persist($customer);

        $manager->flush();
    }
}
