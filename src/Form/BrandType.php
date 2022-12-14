<?php

namespace App\Form;

use App\Entity\Brand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class BrandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name : ',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control w-50 mb-4'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Le champ ne peut etre vide']),
                    new Length(['min' => 3, 'minMessage' => 'Le nom doit contenir au minimum {{ limit }} caracteres !']),
                ]
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Address :',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control w-50 mb-4'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Le champ ne peut etre vide']),
                    new Length(['min' => 10, 'minMessage' => 'L\'adresse doit contenir au minimum {{ limit }} caracteres !']),
                ]
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Created at :',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control w-50 mb-4'
                ],
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Brand::class,
        ]);
    }
}
