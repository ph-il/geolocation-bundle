<?php

namespace Phil\GeolocationBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

/**
 * Default form type for the Address entity
 */
class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('country', 'country', array(
        ));
        $builder->add('region', 'text', array(
            'required' => false
        ));
        $builder->add('postalCode', 'text', array(
            'required' => false
        ));
        $builder->add('location', 'text', array(
        ));
        $builder->add('streetAddress', 'text', array(
        ));

        parent::buildForm($builder, $options);
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Phil\GeolocationBundle\Entity\Address',
        );
    }

    public function getName()
    {
        return 'address';
    }
}
