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

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre prénom'
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
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre nom'
                ],
                'constraints' => [
                    new Length([
                    'min' => 1,
                    'max' => 30
                ]),
                new NotBlank(),
                new NotNull()]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre adresse e-mail'
                ],
                'constraints' => [
                    new Length([
                    'min' => 2,
                    'max' => 70
                ]),
                new NotBlank(),
                new NotNull(),
                new Email()]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques',
                'label' => 'Mot de passe',
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
                'first_options' => ['label' => 'Mot de passe', 'attr' => [
                    'placeholder' => 'Veuillez saisir un mot de passe'
                ]],
                'second_options' => ['label' => 'Confirmation de votre mot de passe', 'attr' => [
                    'placeholder' => 'Veuillez confirmer votre mot de passe'
                ]]
            ])
            
            ->add('submit', SubmitType::class, [
                'label' => "Créer mon compte"
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
