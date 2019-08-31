<?php

namespace OmsBundle\Form;

use OmsBundle\Entity\User;
use OmsBundle\OmsBundle;
use OmsBundle\Service\Roles\RoleServiceInteface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    private $roleService;

    public function __construct(RoleServiceInteface $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username',TextType::class,[])
                ->add('password',TextType::class,[])
                ->add('fullName',TextType::class,[])
                ->add('userRoles',EntityType::class,[
                        'class' => 'OmsBundle:Role',
                        'expanded' => true,
                        'multiple' => true
                    ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OmsBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'omsbundle_user';
    }


}
