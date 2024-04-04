<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

class KernelTestCase extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    protected KernelBrowser $client;
    protected EntityManagerInterface $em;
    protected ValidatorInterface $validator;

    public function setUp(): void
    {
        self::bootKernel();
        $this->em = self::getContainer()->get(EntityManagerInterface::class);
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
        parent::setUp();
    }

    public function assertHasErrors(object $entity, int $expectedErrorCount): void
    {
        $this->setUp();
        $errors = $this->validator->validate($entity);
        $messages = [];

        if (count($errors) > 0) {
            /** @var ConstraintViolationInterface $error */
            foreach ($errors as $error) {
                $messages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }
        }
        $errorMessage = implode(PHP_EOL, $messages);
        $this->assertCount($expectedErrorCount, $errors, "Expected $expectedErrorCount errors, got " . count($errors) . ":\n" . $errorMessage);
    }

    public function remove(object $entity): void
    {
        $this->em->remove($this->em->getRepository($entity::class)->find($entity->getId()));
    }
}