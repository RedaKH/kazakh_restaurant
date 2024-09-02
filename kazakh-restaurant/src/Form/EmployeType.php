<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\Employe;
use App\Enum\EmployeStatus;
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
            ->add('status',ChoiceType::class,[
                'choices'=>[
                    'Admin'=>EmployeStatus::admin,
                    'Chef'=>EmployeStatus::chef,
                    'Serveur'=>EmployeStatus::serveur,
                    'livreur'=>EmployeStatus::livreur,
                    'autre'=>EmployeStatus::autre
                ]
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
