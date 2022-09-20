<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
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
                ]
            ])
            ->add('description', TextareaType::class, [
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
                ]
            ])
            ->add('price')
//            ->add('brand')
//            ->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
