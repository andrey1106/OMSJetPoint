<?php

namespace OmsBundle\Form;

use OmsBundle\Entity\CutOrder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CutOrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('company',EntityType::class,[
                'class' => 'OmsBundle:Company',])
                ->add('contact',EntityType::class,[
                    'class' => 'OmsBundle:Contact',])
                ->add('orderstatus',EntityType::class,[
                    'class' => 'OmsBundle:OrderStatus',])
//                ->add('totalNoVAT')
                ->add('prices', CollectionType::class,[
                'entry_type' => PriceType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CutOrder::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'omsbundle_cutorder';
    }


}
