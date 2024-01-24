<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'label' => 'I am a:',
                'mapped' => false,
                'choices' => [
                    'Traveler' => 'user',
                    'Host' => 'host',
                    'Both' => 'host'
                ],
                'attr' => [
                    'class' => 'form-control  mb-2'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'First Name',
                'attr' => [
                    'class' => 'form-control  mb-2'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last Name',
                'attr' => [
                    'class' => 'form-control  mb-2'
                ]
            ])
            ->add('birthyear', NumberType::class, [
                'label' => 'Your birth Year',
                'attr' => [
                    'class' => 'form-control  mb-2'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Your billing address',
                'attr' => [
                    'class' => 'form-control  mb-2'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Your city',
                'attr' => [
                    'class' => 'form-control  mb-2'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'Your country',
                'attr' => [
                    'class' => 'form-control  mb-2'
                ]
            ])
            ->add('job', TextType::class, [
                'label' => 'Your job',
                'attr' => [
                    'class' => 'form-control  mb-2'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Your profile picture',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control-file mb-2'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'The file is too large ({{ size }} {{ suffix }}). Allowed maximum size is {{ limit }} {{ suffix }}.',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
