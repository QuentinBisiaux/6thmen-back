<?php

namespace App\Tests\Domain\Team;

use App\Domain\Team\Franchise;
use App\Tests\FixturesTrait;
use App\Tests\KernelTestCase;

class FranchiseTest extends KernelTestCase
{
    use FixturesTrait;

    public function getEntity(): Franchise
    {
        /** @var Franchise $franchise */
        ['valid_franchise' => $franchise] = $this->loadFixtures(['franchise']);
        return $franchise;
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testNotBlankName()
    {
        $franchise = $this->getEntity()->setName('');
        $this->assertHasErrors($franchise, 1);
    }

    public function testNotBlankTricode()
    {
        $franchise = $this->getEntity()->setTricode('');
        $this->assertHasErrors($franchise, 2);
    }

    public function testTricodeLength()
    {
        $this->assertHasErrors($this->getEntity()->setTricode('AB'), 2);
        $this->assertHasErrors($this->getEntity()->setTricode('ABCC'), 2);
    }

    public function testTricodeOnlyCapitalLetters()
    {
        $this->assertHasErrors($this->getEntity()->setTricode('AbC'), 1);
        $this->assertHasErrors($this->getEntity()->setTricode('123'), 1);
        $this->assertHasErrors($this->getEntity()->setTricode('abc'), 1);
        $this->assertHasErrors($this->getEntity()->setTricode('/**'), 1);
    }

    public function testSlugNotBlank()
    {
        $this->assertHasErrors($this->getEntity()->setSlug(''), 1);
    }

    public function testSlugFormat()
    {
        $this->assertHasErrors($this->getEntity()->setSlug('/'), 1);
        $this->assertHasErrors($this->getEntity()->setSlug('azerty/'), 1);
        $this->assertHasErrors($this->getEntity()->setSlug('/azerty'), 1);
    }

    public function testEndedInAlwaysAfterCreatedIn()
    {
        $this->assertHasErrors($this->getEntity()->setEndedIn(new \DateTime('12/31/1950')), 1);
    }


}