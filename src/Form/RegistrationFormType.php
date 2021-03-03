<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('email')
            ->add(
                'countryCode'
            )
            ->add('phoneNumber', NumberType::class)
            ->add(
                'agreeTerms',
                CheckboxType::class,
                [
                    'mapped'      => false,
                    'constraints' => [
                        new IsTrue(
                            [
                                'message' => 'You should agree to our terms.',
                            ]
                        ),
                    ],
                ]
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    // instead of being set onto the object directly,
                    // this is read and encoded in the controller
                    'mapped'          => false,
                    'type'            => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options'         => ['attr' => ['class' => 'password-field']],
                    'required'        => true,
                    'first_options'   => ['label' => 'Password'],
                    'second_options'  => ['label' => 'Repeat Password'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
