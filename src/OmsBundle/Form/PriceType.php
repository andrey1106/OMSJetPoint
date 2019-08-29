<?php

namespace OmsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('price', null, ['label' => false,
        ])
            ->add('quantity', null, ['label' => false,])
            ->add('product', EntityType::class, [
                'class' => 'OmsBundle:Product',
                'label' => false,
            ])
            ->add('material', EntityType::class, [
                'class' => 'OmsBundle:Material',
                'label' => false,
            ])
//                ->add('order',EntityType::class,[
//                    'class' => 'OmsBundle:CutOrder',])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OmsBundle\Entity\Price'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'omsbundle_price';
    }


}
