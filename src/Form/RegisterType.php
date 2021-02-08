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
use Symfony\Component\Validator\Constraints\Length;

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
                'constraints' => new Length([
                    'min' => 1,
                    'max' => 30
                ])
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre nom'
                ],
                'constraints' => new Length([
                    'min' => 1,
                    'max' => 30
                ])
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre adresse e-mail'
                ],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 60
                ])
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques',
                'label' => 'Mot de passe',
                'required' => true,
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
