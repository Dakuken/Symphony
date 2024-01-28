<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class InscriptionController extends AbstractController
{

    #[Route('/{_locale}/inscription', name: 'app_inscription', requirements: ['_locale' => 'en|fr'])]
    public function inscription(AuthenticationUtils $authenticationUtils,
                                Request $request,
                                UserPasswordHasherInterface $passwordHasher,
                                EntityManagerInterface $entityManager)
    : Response
    {

        // Récupérer l'erreur de connexion si il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Encoder le mot de passe
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();
            // Ajouter un message flash
            $this->addFlash('success', 'Inscription réussie. Vous pouvez maintenant vous connecter.');

            // Rediriger vers la page de connexion
            return $this->redirectToRoute('app_login', ['error' => $error, "_locale" => $request->getLocale()]);

        }
        else {
            $this->addFlash('error', 'Isdfk,sod,fnscription réussie. Vous pouvez maintenant vous connecter.');

        }
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }
    
}
