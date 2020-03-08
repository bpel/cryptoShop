<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'LabelProductChoice',
                'expanded'     => false,
                'multiple'     => false,
                'label'        => false,
                'attr' => [
                    'class' => 'select',
                    'placeholder' => 'Produit'
                ],
            ])
            ->add('price')
            ->add('quantity', IntegerType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                    new Type('integer')
                ],
                'attr' => [
                    'class' => 'input',
                    'placeholder' => 'Quantité',
                    'min' => 1,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
