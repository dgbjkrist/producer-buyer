<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Producer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $userPasswordEncoderInterface;
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->userPasswordEncoderInterface = $userPasswordEncoderInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $producer = new Producer();
        $producer->setPassword($this->userPasswordEncoderInterface->encodePassword($producer, "password"));
        $producer->setLastName("Kokora");
        $producer->setFirstName("DJEGBA");
        $producer->setEmail("producer@gmail.com");
        $manager->persist($producer);

        $customer = new Customer();
        $customer->setPassword($this->userPasswordEncoderInterface->encodePassword($customer, "password"));
        $customer->setLastName("Christian");
        $customer->setFirstName("JEAN");
        $customer->setEmail("customer@gmail.com");
        $manager->persist($customer);

        $manager->flush();
    }
}
