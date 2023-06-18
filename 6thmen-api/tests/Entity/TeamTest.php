<?php

namespace App\Test\Entity;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Validator\ConstraintViolation;

class TeamTest extends KernelTestCase
{

    public function getEntity(): Team
    {
        return (new Team)
            ->setName('Minnesota Timberwolves')
            ->setRank(1)
            ->setVictory(71)
            ->setCreatedAt(new \DateTimeImmutable());
    }

    public function assertHasErrors(Team $team, int $expected): void
    {
        self::bootKernel();
        $container = static::getContainer();
        /** @var Container $container */
        $errors = $container->get('validator')->validate($team);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($expected, $errors, implode(', ', $messages));
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidRank()
    {
        $this->assertHasErrors($this->getEntity()->setRank(0), 1);
        $this->assertHasErrors($this->getEntity()->setRank(31), 1);
    }

    public function testInvalidVictory()
    {
        $this->assertHasErrors($this->getEntity()->setVictory(-1), 1);
        $this->assertHasErrors($this->getEntity()->setVictory(83), 1);
    }

}