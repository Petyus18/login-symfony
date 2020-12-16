<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\EmployeeEntity;

class EmployeeEntityType extends AbstractType {

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('birth_date')
            ->add('first_name')
            ->add('last_name')
            ->add('gender')
            ->add('hire_date');
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => EmployeeEntity::class,
        ]);
    }
}
