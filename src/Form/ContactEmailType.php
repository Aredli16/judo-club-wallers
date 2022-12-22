<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
class ContactEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'attr' =>[
                    'class' => 'from-control',
                    'minlength' => '2',
                    'maxlength' => '180'
                ],
                'label' => "AdresseEmail",
                'constraints' =>[
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' =>180])
                ]
            ])
            ->add('subject',TextType::class,['attr' =>[
                'class' => 'from-control',
                'min' => '2',
                'max' => '100'
            ],
            'label' => "Subject",
            'constraints' =>[
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2, 'max' =>100])
            ]
            ])
            ->add('message',TextareaType::class,['attr' =>[
                'class' => 'from-control',
            ],
            'label' => "Message",
            'constraints' =>[
                new Assert\NotBlank()
            ]
            ])
            ->add('fichierjoindre',FileType::class,[
                'attr' =>[
                'class' => 'from-control',
            ],
                'label' => "Fichier a joindre",

            'required' =>false
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
