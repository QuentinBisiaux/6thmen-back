<?php

namespace App\Controller;

use App\Entity\Standing;
use App\Form\StandingType;
use App\Repository\StandingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/standing')]
#[IsGranted('ROLE_ADMIN')]
class StandingController extends AbstractController
{
    #[Route('/', name: 'app_standing_index', methods: ['GET'])]
    public function index(StandingRepository $standingRepository): Response
    {
        return $this->render('standing/index.html.twig', [
            'standings' => $standingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_standing_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StandingRepository $standingRepository): Response
    {
        $standing = new Standing();
        $form = $this->createForm(StandingType::class, $standing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $standing->setCreatedAt(new \DateTimeImmutable());
            $standingRepository->save($standing, true);

            return $this->redirectToRoute('app_standing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('standing/new.html.twig', [
            'standing' => $standing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_standing_show', methods: ['GET'])]
    public function show(Standing $standing): Response
    {
        return $this->render('standing/show.html.twig', [
            'standing' => $standing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_standing_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Standing $standing, StandingRepository $standingRepository): Response
    {
        $form = $this->createForm(StandingType::class, $standing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $standing->setUpdatedAt(new \DateTimeImmutable());
            $standingRepository->save($standing, true);

            return $this->redirectToRoute('app_standing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('standing/edit.html.twig', [
            'standing' => $standing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_standing_delete', methods: ['POST'])]
    public function delete(Request $request, Standing $standing, StandingRepository $standingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$standing->getId(), $request->request->get('_token'))) {
            $standingRepository->remove($standing, true);
        }

        return $this->redirectToRoute('app_standing_index', [], Response::HTTP_SEE_OTHER);
    }
}
