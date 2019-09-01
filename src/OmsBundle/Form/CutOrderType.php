<?php

namespace OmsBundle\Form;

use OmsBundle\Entity\Company;
use OmsBundle\Entity\CutOrder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
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
                ->add('orderstatus',EntityType::class,[
                    'class' => 'OmsBundle:OrderStatus',])
                ->add('prices', CollectionType::class,[
                'entry_type' => PriceType::class,
                'label' => false,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ]);


        $formModifier = function (FormInterface $form, Company $company = null) {
            $contacts = null === $company ? [] : $company->getContacts();

            $form->add('contact', EntityType::class, [
                'class' => 'OmsBundle:Contact',
                'placeholder' => '',
                'choices' => $contacts,
            ]);
        };
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. Company
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getCompany());
            }
        );
        $builder->get('company')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $company = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $company);
            }
        );
    }



    /**
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
