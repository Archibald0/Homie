<?php

namespace HomieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class CookerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label'=>'Username'
            ))
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
                'label'=>'Digicode',
                'required'=>false
            ))
            ->add('complement', TextType::class, array(
                'label'=>'Special information',
                'required'=>false
            ))
            ->add('phone', NumberType::class, array(
                'label'=>'Phone number'
            ))
            ->add('email', EmailType::class, array(
                'label'=>'Email'
            ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }


}
