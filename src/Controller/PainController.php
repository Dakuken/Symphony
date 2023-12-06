<?php

namespace App\Controller;

use App\Entity\Pain;
use App\Form\PainType;
use App\Repository\PainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/pain', name: 'pain_')]
class PainController extends AbstractController
{
    #[Route('', name: 'creation', methods: ['GET', 'POST'])]
    public function creation(Request $request, EntityManagerInterface $em): Response
    {
        $pain = new Pain();
        $form = $this->createForm(PainType::class, $pain);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($pain);
            $em->flush();

            $this->addFlash('success', 'Pain créé!');
            return $this->redirectToRoute('pain_liste');
        }

        return $this->render('pain/ajout_pain.html.twig', [
            'pain' => $pain,
            'form' => $form->createView()
        ]);
    }

    #[Route('/liste', name: 'liste')]
    public function liste(PainRepository $painRepository): Response
    {
        $pains = $painRepository->findAll();
        return $this->render('pain/liste_pain.html.twig', [
            'pains' => $pains,
        ]);

    }

    #[Route('/{id\<d+>}/update', name: 'modification', methods: ['GET', 'POST'])]
    public function modification(pain $pain, Request $request, EntityManagerInterface $em, painRepository $painRepository): Response
    {
        $pain = $painRepository->find($pain);
        $form = $this->createForm(PainType::class, $pain);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Pain modifié!');
            return $this->redirectToRoute('pain_liste');
        }

        return $this->render('pain/ajout_pain.html.twig', [
            'pain' => $pain,
            'form' => $form->createView()
        ]);
    }

    #[Route('{id\<d+>}/supprimer', name: 'supprimer', methods: ['GET', 'DELETE'])]
    public function supprimer(Pain $pain, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        // Utilisation d'un token de suppression peut être intéressant dans le cours.
        $em->remove($pain);
        $em->flush();
        $this->addFlash('success', 'Pain supprimé!');

        return $this->redirectToRoute('pain_liste');

    }
}
