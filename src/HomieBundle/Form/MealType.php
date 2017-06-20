<?php

namespace HomieBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label'=>'Food type'
            ))
            ->add('description', TextareaType::class, array(
                'label'=>'Description'
            ))
            ->add('delay', NumberType::class, array(
                'label'=>'Time to cook it (min)'
            ))
            ->add('price', NumberType::class, array(
                'label'=>'Price (€)'
            ))
            ->add('meal_type', EntityType::class, array(
                'class' => 'HomieBundle\Entity\Meal_type',
                'label' => 'Meal Type'
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HomieBundle\Entity\Meal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'homiebundle_meal';
    }


}
