<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\Type;

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
                    'class' => 'form-control w-50 mb-4',
                    'placeholder' => 'Enter a product name...'
                ],
                'required' => false,
// Les contraintes ont été redéfinies directement dans l'entity Product
//                'constraints' => [
//                    new NotBlank(['message' => 'Le nom ne peut etre vide']),
//                    new Length(['min' => 3, 'minMessage' => 'Le nom doit contenir au minimum {{ limit }} caracteres !'])
//                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description : ',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control w-50 mb-4'
                ],
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'La description ne peut etre vide']),
                    new Length(['min' => 10, 'minMessage' => 'La description doit contenir au minimum {{ limit }} caracteres !'])
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price : ',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control w-50 mb-4'
                ],
//                'divisor' => 100,
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Le champ ne peut etre vide']),
                    new PositiveOrZero(),
                    new Type(['type' => 'float']),
                ]
            ])
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
                'placeholder' => 'Brand',
                'label' => 'Brand :',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control w-50 mb-4'
                ],
                'required' => false,
                'constraints' => [
                    new Count(['min' => 1, 'max' => 1]),
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Categories',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'label' => 'Categories :',
                'label_attr' => [
                    'class' => 'form-label',
                ],
//                'attr' => [
//                    'class' => 'form-control w-50 mb-4'
//                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
