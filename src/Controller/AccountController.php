<?php // src/Controller/AccountController.php


namespace App\Controller;

use App\Entity\WordleConfiguration;
use App\Form\Type\WordleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


#[Route('/{_locale}/account', name: 'account_', requirements: ['_locale' => 'en|fr'])]
class AccountController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/security', name: 'security')]
    public function securityOptions(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Création des formulaires
        $emailForm = $this->createFormBuilder($user)
            ->add('email', EmailType::class, [ 'label' => false])
            
            ->getForm();

        $passwordForm = $this->createFormBuilder()
            ->add('newPassword', PasswordType::class, ['label' => false])
            ->getForm();

        $emailForm->handleRequest($request);
        $passwordForm->handleRequest($request);

        if ($emailForm->isSubmitted() && $emailForm->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Votre adresse e-mail a été mise à jour.');
            return $this->redirectToRoute('account_security');
        }

        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($user, $passwordForm->get('newPassword')->getData());
            $user->setPassword($hashedPassword);
            $entityManager->flush();
            $this->addFlash('success', 'Votre mot de passe a été mis à jour.');
            return $this->redirectToRoute('app_logout');
        }

        // Passer les formulaires au template
        return $this->render('account/security.html.twig', [
            'emailForm' => $emailForm->createView(),
            'passwordForm' => $passwordForm->createView(),
            'user' => $user
        ]);
    }

    #[Route('/create-wordle', name: 'create_wordle')]
    public function create(Request $request,EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        if (!$user) {
            // Gérez la situation où l'utilisateur n'est pas connecté
            // Par exemple, rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }
        $wordles = $entityManager->getRepository(WordleConfiguration::class)->findBy(['author' => $user]);
        $wordle = new WordleConfiguration();
        $wordle->setAuthor($user);
        // Création du formulaire
        $form = $this->createForm(WordleType::class, $wordle);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $wordle->setWordLength(strlen($wordle->getSolution()));
            $entityManager->persist($wordle);
            $entityManager->flush();

            // Redirection ou traitement après la création du wordle
        }

        return $this->render('account/create.html.twig', [
            'form' => $form->createView(),
            'wordles' => $wordles, // Ajoutez les wordles à la vue
        ]);
    }

    #[Route('/edit-wordle/{id}', name: 'wordle_edit')]
    public function editWordle(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $wordle = $entityManager->getRepository(WordleConfiguration::class)->find($id);

        if (!$wordle || $wordle->getAuthor() !== $this->getUser()) {
            throw $this->createNotFoundException('Wordle non trouvé ou accès non autorisé.');
        }

        $form = $this->createForm(WordleType::class, $wordle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            // Rediriger après modification
            return $this->redirectToRoute('account_create_wordle');
        }

        return $this->render('account/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/delete-wordle/{id}', name: 'wordle_delete', methods: ['POST'])]
    public function deleteWordle(int $id, EntityManagerInterface $entityManager): Response
    {
        $wordle = $entityManager->getRepository(WordleConfiguration::class)->find($id);

        if (!$wordle || $wordle->getAuthor() !== $this->getUser()) {
            // Gérer le cas où le wordle n'est pas trouvé ou l'utilisateur n'est pas autorisé
            throw $this->createNotFoundException('Wordle non trouvé ou accès non autorisé.');
        }

        $entityManager->remove($wordle);
        $entityManager->flush();

        // Rediriger vers la liste des wordles après la suppression
        return $this->redirectToRoute('account_create_wordle');
    }
}
