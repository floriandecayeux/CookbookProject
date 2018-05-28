<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use App\Entity\Recette;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RecetteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', null, array(
                    'label_attr' => array('class' => 'MYCLASSFOR_LABEL'),
                    'attr'       => array('class' => 'MYCLASSFOR_INPUTS')))
                ->add('nbPersonnes', ChoiceType::class, array(
                    'label_attr' => array('class' => 'MYCLASSFOR_LABEL'),
                    'attr'       => array('class' => 'MYCLASSFOR_INPUTS'),
                    'choices'  => range(1,12)))
                ->add('tempsPreparation', ChoiceType::class, array(
                    'label_attr' => array('class' => 'MYCLASSFOR_LABEL'),
                    'attr'       => array('class' => 'MYCLASSFOR_INPUTS'),
                    'choices'    => range(10,120) ))
                ->add('categorie', ChoiceType::class, array(
                    'label_attr' => array('class' => 'MYCLASSFOR_LABEL'),
                    'attr'       => array('class' => 'MYCLASSFOR_INPUTS'),
                    'choices'  => array(
                        'Entrée' => null,
                        'Plat' => true,
                        'Dessert' => false,
                        'Appéritif' => false
                    )));
           /*     ->add('Temps Préparation',RangeType::class, array(
                    'label_attr' => array('class' => 'MYCLASSFOR_LABEL'),
                    'attr'       => array('class' => 'MYCLASSFOR_INPUTS', 'min' => 10, 'max' => 120)));*/

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Recette::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'new_recette';
    }


}
