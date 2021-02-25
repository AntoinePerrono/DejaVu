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
            ->add('pseudo', TextType::class, [
                'label' => 'Votre pseudo',
                'constraints' => new Length([
                    'min' =>2,
                    'max'=> 200
                ]),
                'attr' => [
                    'placeholder'=> "Entrer un pseudo"
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'placeholder'=> "Entrer un email"
                ]
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                'invalid_message' => 'Les deux mots de passes saisient doivent être indentique.',
                'required' => true,
                'first_options' => ['label' => 'Votre mot de passe', 'attr' => ['placeholder' => 'Répéter le mot de passe']],
                'second_options' => ['label' => 'Confirmez votre mot de passe', 'attr' => ['placeholder' => 'Répéter le mot de passe']],
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
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
