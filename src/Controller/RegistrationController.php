<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager)
    {
        // Créer une nouvelle instance de Client et User
        $client = new Client();
        $user = new User();
        
        // Créer le formulaire d'inscription pour le Client
        $form = $this->createForm(ClientRegistrationType::class, $client);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'email et le mot de passe depuis le formulaire
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();

            // Assigner ces informations à l'objet User
            $user->setEmail($email);
            $user->setPassword($password);  // Ne pas encoder le mot de passe

            // Attribuer le rôle "ROLE_CLIENT" à l'utilisateur
            $user->setRoles(['ROLE_CLIENT']);

            // Associer l'utilisateur au client
            $client->setUser($user);

            // Sauvegarder l'utilisateur et le client dans la base de données
            $entityManager->persist($user);
            $entityManager->persist($client);
            $entityManager->flush();

            // Rediriger vers la page de connexion après l'inscription
            return $this->redirectToRoute('app_login');
        }

        // Afficher le formulaire d'inscription
        return $this->render('registration/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
