<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('email'),
            
            // Utilisation de TextField pour le mot de passe, avec option de masquage du texte
            TextField::new('password')
                ->setFormTypeOption('attr', ['autocomplete' => 'new-password']) // Empêche la suggestion de mot de passe
                ->setHelp('Entrez un mot de passe sécurisé.'),
            
            // Ajout du champ de sélection pour les rôles
            ChoiceField::new('roles')
                ->setChoices([
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    'Client' => 'ROLE_CLIENT', // Si tu as un rôle 'ROLE_CLIENT'
                ])
                ->allowMultipleChoices() // Permet de sélectionner plusieurs rôles si nécessaire
                ->setHelp('Sélectionnez le rôle de l\'utilisateur.'),
        ];
    }
}
