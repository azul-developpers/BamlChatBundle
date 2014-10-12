<?php

namespace Baml\ChatBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConversationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('title','text',array('label'=>'Nom de la conversation'))
            ->add('participants','entity', array(
				'label' => 'Destinataires',
				'class'    => 'BamlUserBundle:User',
				'property' => 'username',
				'multiple' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baml\ChatBundle\Entity\Conversation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baml_chatbundle_conversation';
    }
}
