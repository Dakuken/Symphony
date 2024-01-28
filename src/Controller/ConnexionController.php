<?php

namespace App\Controller;

use App\Form\ConnexionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ConnexionController extends AbstractController
{

    #[Route('/{_locale}/connexion', name: 'app_login',requirements: ['_locale' => 'en|fr'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer l'erreur de connexion si il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom d'utilisateur entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('connexion/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/{_locale}/logout', name: 'app_logout',requirements: ['_locale' => 'en|fr'])]
    public function logout()
    {
        // Le code de déconnexion est géré par Symfony
    }
}
