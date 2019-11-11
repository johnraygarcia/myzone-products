<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User;
        $user
        ->setEmail("john.garcia@gmail.com")
        ->setRoles(['ROLE_USER']);

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'myzone'
        ));

        $manager->persist($user);
        $manager->flush();

        $user2 = new User;
        $user2
            ->setEmail("admin@gmail.com")
            ->setRoles(['ROLE_USER']);

        $user2->setPassword($this->passwordEncoder->encodePassword(
            $user2,
            'myzone'
        ));

        $manager->persist($user2);
        $manager->flush();
    }
}
