<?php

namespace App\Form;

use App\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class)
            ->add('content',CKEditorType::class,[
                'config'=>[
                    'toolbar'=>'basic',
                    'height'=>'300px'
                ]
            ]
            )
            ->add('image', FileType::class, [
                'label' => 'Image (JPG, PNG file)',
                'mapped' => false, // Indique que ce champ n'est pas lié à une propriété de l'entité
                'required' => false, // L'image n'est pas obligatoire
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image (JPG, PNG)',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer']);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
