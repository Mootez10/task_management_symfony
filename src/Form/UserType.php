<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password')
            // Add roles with choice type, allowing multiple selections
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Manager' => 'ROLE_MANAGER',
                    'Admin' => 'ROLE_ADMIN',
                    'Employee' => 'ROLE_EMPLOYEE',
                ],
                'multiple' => true,  // Allow multiple roles to be selected
                'expanded' => true,  // Use checkboxes or radio buttons (depending on the requirement)// Pre-set roles if any

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
