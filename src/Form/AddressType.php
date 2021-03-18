<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'adresse",
                'attr' => [
                    'placeholder' => "Veuillez saisir le nom de l'adresse. Ex : Mon domicile"
                ],
                'constraints' => [
                    new Length([
                    'min' => 1,
                    'max' => 60
                ]),
                new NotBlank(),
                new NotNull()]
            ])
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
                'attr' => [
                    'placeholder' => "Veuillez saisir le prénom du destinataire"
                ],
                'constraints' => [
                    new Length([
                    'min' => 1,
                    'max' => 30
                ]),
                new NotBlank(),
                new NotNull()]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'attr' => [
                    'placeholder' => "Veuillez saisir le nom du destinataire"
                ],
                'constraints' => [
                    new Length([
                    'min' => 1,
                    'max' => 30
                ]),
                new NotBlank(),
                new NotNull()]
            ])
            ->add('company', TextType::class, [
                'label' => "Société (facultatif)",
                'required' => false,
                'attr' => [
                    'placeholder' => "Veuillez saisir le nom de la société"
                ],
                'constraints' => [
                    new Length([
                    'min' => 1,
                    'max' => 30
                ])]
            ])
            ->add('address', TextType::class, [
                'label' => "Adresse",
                'attr' => [
                    'placeholder' => "Veuillez saisir l'adresse"
                ],
                'constraints' => [
                    new Length([
                    'min' => 1,
                    'max' => 90
                ]),
                new NotBlank(),
                new NotNull()]
            ])
            ->add('postal_code', TextType::class, [
                'label' => "Code postal",
                'attr' => [
                    'placeholder' => "Veuillez saisir le code postal de l'adresse"
                ],
                'constraints' => [                                        
                    new NotBlank(),
                    new NotNull(),
                    new Regex([
                        'pattern' => '/^[0-9]{5}$/',
                        'message' => 'Votre code postal doit avoir être composé de 5 chiffres'
                    ])]
            ])
            ->add('city', TextType::class, [
                'label' => "Ville",
                'attr' => [
                    'placeholder' => "Veuillez saisir la ville de l'adresse"
                ],
                'constraints' => [
                    new Length([
                    'min' => 1,
                    'max' => 30
                ]),
                new NotBlank(),
                new NotNull()]
            ])
            ->add('country', TextType::class, [
                'label' => "Pays",
                'attr' => [
                    'placeholder' => "Veuillez saisir le pays de l'adresse"
                ],
                'constraints' => [
                    new Length([
                    'min' => 1,
                    'max' => 30
                ]),
                new NotBlank(),
                new NotNull()]
            ])
            ->add('phone_number', TextType::class, [
                'label' => "Téléphone",
                'attr' => [
                    'placeholder' => "Veuillez saisir le numéro de téléphone : 06XXXXXXXX"
                ],
                'constraints' => [                                        
                new NotBlank(),
                new NotNull(),
                new Regex([
                    'pattern' => '/^0[0-9]{9}$/',
                    'message' => 'Votre numéro de téléphone doit avoir un format 0XXXXXXXXX'
                ])]
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
