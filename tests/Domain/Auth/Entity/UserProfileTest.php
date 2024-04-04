<?php

namespace App\Tests\Domain\Auth\Entity;

use App\Domain\Auth\Entity\UserProfile;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class UserProfileTest extends KernelTestCase
{

    use FixturesTrait;

    public function getEntity(): UserProfile
    {
        /** @var UserProfile $userProfile */
        ['user_profile_1' => $userProfile] = $this->loadFixtures(['user']);
        return $userProfile;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testCascadeDeleteForUser()
    {
        $userProfile = $this->getEntity();
        $userRepository = $this->em->getRepository(UserProfile::class);
        $userProfileId = $userProfile->getId();
        $this->remove($userProfile->getUser());
        $this->em->flush();
        $this->em->clear();
        $this->assertEquals(null, $userRepository->find($userProfileId));

    }
}