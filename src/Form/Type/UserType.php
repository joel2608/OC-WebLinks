<?php

namespace WebLinks\form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', TextType::class, array(
                'label'       => "Nom d'utilisateur",
                'attr'        => ['placeholder' => 'Exemple : Marco'],
                'required'    => true,
                'constraints' => new Assert\NotBlank(),
            ))
            ->add('password', RepeatedType::class, array(
                'type'            => PasswordType::class,
                'constraints'     => new Assert\Length(['min' => 5]),
                'invalid_message' => 'Les 2 mots de passe doivent être identique.',
                'options'         => array(
                    'required' => true
                ),
                'first_options'   => array(
                    'label'       => 'Password',
                    'required'    => true,
                    'attr'        => ['placeholder' => 'Un minimum de 6 caractères est nécessaire'],
                ),
                'second_options'  => array(
                    'label'       => 'Repeat password',
                    'attr'        => ['placeholder' => 'Retapez votre mot de passe'],
                    'required'    => true,
                ),
            ))
            ->add('role', ChoiceType::class, array(
                'choices' => array(
                    'Admin' => 'ROLE_ADMIN',
                    'User'  => 'ROLE_USER'
                )
            ));
    }
    public function getName() {
        return 'user';
    }
}