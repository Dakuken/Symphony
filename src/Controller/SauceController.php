<?php

namespace App\Controller;

use App\Entity\Sauce;
use App\Form\SauceType;
use App\Repository\SauceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/sauce', name: 'sauce_')]
class SauceController extends AbstractController
{
    #[Route('', name: 'creation', methods: ['GET', 'POST'])]
    public function creation(Request $request, EntityManagerInterface $em): Response
    {
        $sauce = new Sauce();
        $form = $this->createForm(SauceType::class, $sauce);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($sauce);
            $em->flush();

            $this->addFlash('success', 'Sauce créé!');
            return $this->redirectToRoute('sauce_liste');
        }

        return $this->render('sauce/ajout_sauce.html.twig', [
            'sauce' => $sauce,
            'form' => $form->createView()
        ]);
    }

    #[Route('/liste', name: 'liste')]
    public function liste(SauceRepository $sauceRepository): Response
    {
        $sauces = $sauceRepository->findAll();
        return $this->render('sauce/liste_sauce.html.twig', [
            'sauces' => $sauces,
        ]);

    }

    #[Route('/{id\<d+>}/update', name: 'modification', methods: ['GET', 'POST'])]
    public function modification(Sauce $sauce, Request $request, EntityManagerInterface $em, sauceRepository $sauceRepository): Response
    {
        $sauce = $sauceRepository->find($sauce);
        $form = $this->createForm(SauceType::class, $sauce);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Sauce modifié!');
            $this->redirectToRoute('sauce_liste');
        }

        return $this->render('sauce/ajout_sauce.html.twig', [
            'sauce' => $sauce,
            'form' => $form->createView()
        ]);
    }

    #[Route('{id\<d+>}/supprimer', name: 'supprimer', methods: ['GET', 'DELETE'])]
    public function supprimer(Sauce $sauce, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        // Utilisation d'un token de suppression peut être intéressant dans le cours.
        $em->remove($sauce);
        $em->flush();
        $this->addFlash('success', 'Sauce supprimé!');

        return $this->redirectToRoute('sauce_liste');

    }
}
