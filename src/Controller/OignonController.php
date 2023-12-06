<?php

namespace App\Controller;

use App\Entity\Oignon;
use App\Form\OignonType;
use App\Repository\OignonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/oignon', name: 'oignon_')]
class OignonController extends AbstractController
{
    #[Route('', name: 'creation', methods: ['GET', 'POST'])]
    public function creation(Request $request, EntityManagerInterface $em): Response
    {
        $oignon = new Oignon();
        $form = $this->createForm(OignonType::class, $oignon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($oignon);
            $em->flush();

            $this->addFlash('success', 'Oignon créé!');
            return $this->redirectToRoute('oignon_liste');
        }

        return $this->render('oignon/ajout_oignon.html.twig', [
            'oignon' => $oignon,
            'form' => $form->createView()
        ]);
    }

    #[Route('/liste', name: 'liste')]
    public function liste(OignonRepository $oignonRepository): Response
    {
        $oignons = $oignonRepository->findAll();
        return $this->render('oignon/liste_oignon.html.twig', [
            'oignons' => $oignons,
        ]);
    }

    #[Route('/{id\<d+>}/update', name: 'modification', methods: ['GET', 'POST'])]
    public function modification(Oignon $oignon, Request $request, EntityManagerInterface $em, OignonRepository $oignonRepository): Response
    {
        $oignon = $oignonRepository->find($oignon);
        $form = $this->createForm(OignonType::class, $oignon);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Oignon modifié!');
            $this->redirectToRoute('oignon_liste');
        }

        return $this->render('oignon/ajout_oignon.html.twig', [
            'oignon' => $oignon,
            'form' => $form->createView()
        ]);
    }

    #[Route('{id\<d+>}/supprimer', name: 'supprimer', methods: ['GET', 'DELETE'])]
    public function supprimer(Oignon $oignon, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        // Utilisation d'un token de suppression peut être intéressant dans le cours.
        $em->remove($oignon);
        $em->flush();
        $this->addFlash('success', 'Oignon supprimé!');

        return $this->redirectToRoute('oignon_liste');

    }
}
