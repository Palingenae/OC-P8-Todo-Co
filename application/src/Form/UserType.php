<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => "Nom d'utilisateur"
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe'
                ],
                'second_options' => [
                    'label' => 'Tapez le mot de passe à nouveau'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email'
                ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle',
                'required' => true,
                'multiple' => false,
                'choices' => [
                    'Utilisateur·rice' => 'ROLE_USER',
                    'Administrateur·rice' => 'ROLE_ADMIN',
                ]
            ])
        ;

        /* This block of code allows to convert above roles to string so we can use them in a select, then to retype them as array after the choice is made. */
        $builder
            ->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    return [$rolesString];
                }
            )
        );
    }
}
