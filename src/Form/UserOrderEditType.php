<?php

namespace App\Form;

use App\Entity\Country;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserOrderEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input',
                    'placeholder' => 'Prénom'
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input',
                    'placeholder' => 'Nom'
                ],
            ])
            ->add('adress', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input',
                    'placeholder' => 'Adresse postale',
                ],
            ])
            ->add('postcode', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input',
                    'placeholder' => 'Code postal',
                ],
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'input',
                    'placeholder' => 'Ville',
                ],
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => false,
                'attr' => [
                    'class' => 'select',
                    'placeholder' => 'Pays'
                ],
            ])
            ->add('products', CollectionType::class, [
                'entry_type' => ProductType::class,
                'allow_add' => true,
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => null
        ]);
    }
}
