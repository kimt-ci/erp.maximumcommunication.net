<?php

namespace App\Form\Erp\User;

use App\Entity\Erp\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Gestionnaire Ressources Humaines' => 'ROLE_HUMAN_RESOURCES',
                    'Gestionnaire Commercial' => 'ROLE_COMMERCIAL',
                    'Gestionnaire Logistique' => 'ROLE_LOGISTICS',
                    'Gestionnaire Comptabilité' => 'ROLE_ACCOUNTING',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'label' => false,
                'multiple' => true,
                'required' => true,

            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et le confirmer mot de passe ne correspondent pas.',
                'required' => false,
                'first_options'  => array('label' => false),
                'second_options' => array('label' => false),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['user_create'],
        ]);
    }
}
