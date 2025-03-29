<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['class' => 'form_control'], 'label' => 'Email'])
            ->add('nom', TextType::class, ['attr' => ['class' => 'form_control'], 'label' => 'Nom'])
            ->add('prenom', TextType::class, ['attr' => ['class' => 'form_control'], 'label' => 'Prenom'])   
            ->add('adresse', TextType::class, ['attr' => ['class' => 'form_control'], 'label' => 'Adresse'])
            ->add('ville', TextType::class, ['attr' => ['class' => 'form_control'], 'label' => 'Ville'])
            ->add('cp', TextType::class, ['attr' => ['class' => 'form_control'], 'label' => 'Code Postal'])
            ->add('type_client', ChoiceType::class, [
                'choices' => [
                    'Entreprise' => 'entreprise',
                    'Particulier' => 'particulier',
                ],
                'expanded' => false, // false pour une liste déroulante
                'multiple' => false, // false pour un choix unique
                'attr' => ['class' => 'form-control'], // Classe Bootstrap pour le style
            ])

            ->add('RGPD', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
