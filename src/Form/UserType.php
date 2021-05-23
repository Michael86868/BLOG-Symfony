<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a username',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your username should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a valid email address.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your email should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('birthdate', BirthdayType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a valid birthdate.',
                    ]),
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Muž' => 'Muž',
                    'Žena' => 'Žena',
                ],
            ])
            ->add('industry', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a industry',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your industry should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                  'value' => '',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a username',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a city',
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Your city should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('bio', TextareaType::class, [
                'attr' => [
                    'row' => 10,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a biography',
                    ]),
                    new Length([
                        'min' => 16,
                        'minMessage' => 'Your biography should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
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
