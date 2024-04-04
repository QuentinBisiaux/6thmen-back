<?php

namespace App\Tests\Domain\Auth\Entity;

use App\Domain\Auth\Entity\User;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class UserTest extends KernelTestCase
{
    use FixturesTrait;

    public function getEntity(): User
    {
        /** @var User $user */
        ['user_1' => $user] = $this->loadFixtures(['user']);
        return $user;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }



}