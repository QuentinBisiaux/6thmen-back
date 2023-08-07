<?php

namespace App\DataFixtures;

use App\Entity\Library\User;
use App\Entity\Library\UserProfile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {}

    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setEmail('admin@admin.fr');
        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user);

        $userProfile = new UserProfile();
        $userProfile->setUsername('admin');
        $userProfile->setProfileImageUrl('hello');
        $userProfile->setLocation('Paris');
        $userProfile->setRawData(['location' => 'Paris']);
        $userProfile->setUser($user);
        $userProfile->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($userProfile);

        $manager->flush();
    }
}
