<?php

namespace App\Form;

use App\Entity\PostComments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' => [
                    'rows' => 3,
                ],
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a content',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your content should be at least {{ limit }} characters',
                        'max' => 4096,
                        'maxMessage' => 'Your content should be longer than {{ limit }} characters',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostComments::class,
        ]);
    }
}
