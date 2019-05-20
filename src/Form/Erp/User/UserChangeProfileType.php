<?php

namespace App\Form\Erp\User;

use App\Entity\Erp\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserChangeProfileType extends AbstractType
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
            ->add('fullName', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('avatarFile', FileType::class, [
                'required' => false,
                'label' => false
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
