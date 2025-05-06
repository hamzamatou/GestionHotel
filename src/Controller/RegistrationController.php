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
      
        $client = new Client();
        $user = new User();
        
        
        $form = $this->createForm(ClientRegistrationType::class, $client);

        
        $form->handleRequest($request);

       
        if ($form->isSubmitted() && $form->isValid()) {
            
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();

           
            $user->setEmail($email);
            $user->setPassword($password);  

            
            $user->setRoles(['ROLE_CLIENT']);

            
            $client->setUser($user);

            
            $entityManager->persist($user);
            $entityManager->persist($client);
            $entityManager->flush();

           
            return $this->redirectToRoute('app_login');
        }

   
        return $this->render('registration/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
