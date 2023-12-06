<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/image', name: 'image_')]
class ImageController extends AbstractController
{
    #[Route('', name: 'creation', methods: ['GET', 'POST'])]
    public function creation(Request $request, EntityManagerInterface $em): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageRequest = $request->files->get('image')['url'];
            $fileName = 'images/uploaded/' . $imageRequest->getClientOriginalName();
            $image->setUrl($fileName);
            $image->setAltText('This is an image!');
            $imageRequest->move('images/uploaded', $imageRequest->getClientOriginalName());
            $em->persist($image);
            $em->flush();

            $this->addFlash('success', 'Image créé!');
            return $this->redirectToRoute('image_liste');
        }

        return $this->render('image/ajout_image.html.twig', [
            'image' => $image,
            'form' => $form
        ]);
    }

    #[Route('/liste', name: 'liste')]
    public function liste(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findAll();

        return $this->render('image/liste_image.html.twig', [
            'images' => $images,
        ]);
    }

    #[Route('/{id\<d+>}/update', name: 'modification', methods: ['GET', 'POST'])]
    public function modification(Image $image, Request $request, EntityManagerInterface $em, ImageRepository $imageRepository): Response
    {
        $image = $imageRepository->find($image);
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Image modifié!');
            return $this->redirectToRoute('image_liste');
        }

        return $this->render('image/ajout_image.html.twig', [
            'image' => $image,
            'form' => $form
        ]);
    }

    #[Route('{id\<d+>}/supprimer', name: 'supprimer', methods: ['GET', 'DELETE'])]
    public function supprimer(Image $image, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        // Utilisation d'un token de suppression peut être intéressant dans le cours.
        $em->remove($image);
        $em->flush();
        $this->addFlash('success', 'Image supprimé!');

        return $this->redirectToRoute('image_liste');

    }
}
