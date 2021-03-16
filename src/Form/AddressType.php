<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'adresse",
                'attr' => [
                    'placeholder' => "Veuillez saisir le nom de l'adresse. Ex : Mon domicile"
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
                'attr' => [
                    'placeholder' => "Veuillez saisir le prénom du destinataire"
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'attr' => [
                    'placeholder' => "Veuillez saisir le nom du destinataire"
                ]
            ])
            ->add('company', TextType::class, [
                'label' => "Société (facultatif)",
                'required' => false,
                'attr' => [
                    'placeholder' => "Veuillez saisir le nom de la société"
                ]
            ])
            ->add('address', TextType::class, [
                'label' => "Adresse",
                'attr' => [
                    'placeholder' => "Veuillez saisir l'adresse"
                ]
            ])
            ->add('postal_code', NumberType::class, [
                'label' => "Code postal",
                'attr' => [
                    'placeholder' => "Veuillez saisir le code postal de l'adresse"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => "Ville",
                'attr' => [
                    'placeholder' => "Veuillez saisir la ville de l'adresse"
                ]
            ])
            ->add('country', TextType::class, [
                'label' => "Pays",
                'attr' => [
                    'placeholder' => "Veuillez saisir le pays de l'adresse"
                ]
            ])
            ->add('phone_number', NumberType::class, [
                'label' => "Téléphone",
                'attr' => [
                    'placeholder' => "Veuillez saisir le numéro de téléphone"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
