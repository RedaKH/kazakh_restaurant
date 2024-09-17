<?php

namespace App\Form;

use App\Entity\Employe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('telephone',TelType::class)
            ->add('email',EmailType::class)
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Chef' => 'ROLE_CHEF',
                    'Serveur' => 'ROLE_SERVEUR',
                    'Livreur' => 'ROLE_LIVREUR',
                    'Employé' => 'ROLE_EMPLOYE',
                ],
                'multiple' => true,
                'expanded' => false, // Utilisation d'un select avec possibilité de sélection multiple
                'attr' => ['class' => 'form-control select'], // Ajout d'une classe CSS pour styliser le select
            ])
            
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class,[
                'label' =>'Enregistrer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
