<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Entity\User;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', null, array(
                    'label_attr' => array('class' => 'MYCLASSFOR_LABEL'),
                    'attr'       => array('class' => 'MYCLASSFOR_INPUTS')))
                ->add('password', PasswordType::class, array(
                    'label_attr' => array('class' => 'MYCLASSFOR_LABEL'),
                    'attr'       => array('class' => 'MYCLASSFOR_INPUTS')))
                ->add('email', null, array(
                    'label_attr' => array('class' => 'MYCLASSFOR_LABEL'),
                    'attr'       => array('class' => 'MYCLASSFOR_INPUTS')));

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'new_user';
    }


}
