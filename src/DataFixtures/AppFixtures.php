<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $time = new \DateTimeImmutable();
        $user = (new User())
            ->setPassword('test')
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
            ->setEmail('lepelley@live.fr')
            ->setNickname('Vincent')
            ->setCreatedAt($time)
            ->setUpdatedAt($time)
        ;
        $user->setPassword($this->passwordHasher->hashPassword($user, 'azerty'));
        $manager->persist($user);

        $manager->flush();
    }
}
