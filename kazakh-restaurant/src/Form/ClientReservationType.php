<?php // src/Form/ReservationType.php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Reservation;
use App\Enum\ReservationType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ReservationType', ChoiceType::class, [
                'choices' => [
                    'Sur place' => ReservationType::SUR_PLACE,
                    'À emporter' => ReservationType::EMPORTER,
                    'Livraison' => ReservationType::LIVRAISON,
                    'Privatisation' => ReservationType::PRIVATISATION,
                ],
                'label' => 'Type de réservation',
            ])
            ->add('date_reservation', DateTimeType::class, [
                'label' => 'Date de réservation',
                'widget' => 'single_text',
            ])
            ->add('nombre_personne', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'required' => false,
            ])
            ->add('client_nom', TextType::class, [
                'mapped' => false, // Ce champ n'est pas directement lié à l'entité Reservation
                'label' => 'Nom du client',
            ])
            ->add('client_prenom', TextType::class, [
                'mapped' => false,
                'label' => 'Prénom du client',
            ])
            ->add('client_adresse', TextType::class, [
                'mapped' => false,
                'label' => 'Adresse',
            ])
            ->add('client_code_postal', IntegerType::class, [
                'mapped' => false,
                'label' => 'Code postal',
            ])
            ->add('client_ville', TextType::class, [
                'mapped' => false,
                'label' => 'Ville',
            ])
            ->add('client_email', EmailType::class, [
                'mapped' => false,
                'label' => 'Email',
            ])
            ->add('client_num_tel', IntegerType::class, [
                'mapped' => false,
                'label' => 'Numéro de téléphone',
            ])
            ->add('plat', TextType::class, [
                'label' => 'Plat commandé',
                'required' => false,
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Valider la réservation',
                'attr'=>['class'=>'button-is-link']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
?>