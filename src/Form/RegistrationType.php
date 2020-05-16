<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("Prénom", "Votre prénom "))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre nom de famille "))
            ->add('picture', UrlType::class, $this->getConfiguration("Photo de profil", "Votre Avatar "))
            ->add('phone', TelType::class, $this->getConfiguration("Numéro de télèphone", "Votre numéro pour vous joindre "))
            ->add('address', TextType::class, $this->getConfiguration("Adresse", "Votre adresse "))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Adresse email "))
            ->add('hash', PasswordType::class, $this->getConfiguration("Mot de passe", "Choisissez un mot de passe "))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration("Confirmation de mot de passe", "Confirmer votre mot de passe "))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
