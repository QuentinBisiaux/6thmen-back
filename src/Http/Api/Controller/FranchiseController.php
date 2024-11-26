<?php

namespace App\Http\Api\Controller;

use App\Domain\Team\Repository\FranchiseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/franchise', name: 'franchise_')]
class FranchiseController extends AbstractController
{
    public function __construct(
        private FranchiseRepository $franchiseRepository,
    )
    {}

    #[Route(path: '/name', name: 'name', methods: ['GET'])]
    public function franchisesByOrderedByName(): JsonResponse
    {
        $franchises = $this->franchiseRepository->findByNameOrdered();
        return $this->json($franchises, 200, [], ['groups' => 'read:team']);
    }

}