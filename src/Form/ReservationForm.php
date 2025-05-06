<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Client;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num', null, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('jourArr', null, [
                'widget' => 'single_text', // pour un input date propre
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('nbjours', null, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('jourDep', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('chambre', EntityType::class, [
                'class' => Chambre::class,
                'choice_label' => 'id',
                'attr' => ['class' => 'form-select'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'id',
                'attr' => ['class' => 'form-select'],
                'label_attr' => ['class' => 'form-label']
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
