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

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => "Mon email"
            ])
            ->add('pseudo', TextType::class, [
                'disabled' => true,
                'label' => "Mon Pseudo"
            ])
            ->add('oldPassword', PasswordType::class, [
                'label' => "Mon mot de passe acutel",
                'mapped' => false,
                'attr' => [
                    'placeholder' => "Saisir votre mot de passe"
                ]
            ])
            ->add('newPassword', RepeatedType::class, [
                "type" => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Les deux mots de passes saisient doivent être indentique.',
                'required' => true,
                'first_options' => ['label' => 'Votre nouveau mot de passe', 'attr' => ['placeholder' => 'Répéter le mot de passe']],
                'second_options' => ['label' => 'Confirmez votre nouveau mot de passe', 'attr' => ['placeholder' => 'Répéter le mot de passe']],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Changer le mot de passe"
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
