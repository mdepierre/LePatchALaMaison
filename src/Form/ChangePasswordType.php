<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon adresse email',
                'constraints' => [
                    new Length([
                    'min' => 2,
                    'max' => 70
                ]),
                new NotBlank(),
                new NotNull(),
                new Email()]
            ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon prénom',
                'constraints' => [
                    new Length([
                    'min' => 1,
                    'max' => 30
                ]),
                new NotBlank(),
                new NotNull()]
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon nom',
                'constraints' => [
                    new Length([
                    'min' => 1,
                    'max' => 30
                ]),
                new NotBlank(),
                new NotNull()]
            ])
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mon mot de passe actuel',
                'attr' => ['placeholder' => 'Veuillez saisir votre mot de passe actuel'
            ],
            'constraints' => [
                new Length([
                    'min' => 8,
                    'max' => 30
                ]),                    
            new NotBlank(),
            new NotNull(),
            new Regex([
                'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#?!@$%^&*-]).{8,30}$/',
                'message' => 'Votre mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial parmis #?!@$%^&*-'
            ])]
            ] )
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le nouveau mot de passe et la confirmation doivent être identiques',
                'label' => 'Mon mot de passe actuel',
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 30
                    ]),                    
                new NotBlank(),
                new NotNull(),
                new Regex([
                    'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#?!@$%^&*-]).{8,30}$/',
                    'message' => 'Votre mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial parmis #?!@$%^&*-'
                ])],
                'first_options' => [
                    'label' => 'Nouveau mot de passe', 
                    'attr' => ['placeholder' => 'Veuillez saisir votre nouveau mot de passe'
                ]],
                'second_options' => [
                    'label' => 'Confirmation de votre nouveau mot de passe', 
                    'attr' => ['placeholder' => 'Veuillez confirmer votre nouveau mot de passe'
                ]]
            ])
            
            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer mon nouveau mot de passe"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
