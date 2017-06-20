<?php

namespace HomieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckoutType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', TextType::class, array(
                'label'=>'Street',
                'attr'=>array(
                    'placeholder'=>'24, Baker Street'
                )
            ))
            ->add('zip_code', TextType::class, array(
                'label'=>'Zipcode'
            ) )
            ->add('town', TextType::class, array(
                'label'=>'Town'
            ))
            ->add('digicode', TextType::class, array(
                'label'=>'Digicode'
            ))
            ->add('complement', TextType::class, array(
                'label'=>'Special information'
            ))
            ->add('Submit', SubmitType::class, array(
                'attr'=>array(
                    'class'=>'btn red'
                )
            ))
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HomieBundle\Entity\Checkout'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'homiebundle_checkout';
    }


}
