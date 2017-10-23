<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class QuestionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('attr' => array(
                'class' => 'form-control custom',
                'placeholder' => 'question.form.question.placeholder'
            ),
                'label' => 'question.form.title.label'
            ))
            ->add('question', TextareaType::class, array('attr' => array(
                'cols' => '5',
                'rows' => '8',
                'placeholder' => 'question.form.explanation.placeholder'
            ),
                'label' => 'question.form.question.label'
            ))
            ->add('city', TextType::class, array('attr' => array(
                'class' => 'form-control custom',
                'placeholder' => 'question.form.city.placeholder'
            ),
                'required' => false,
                'label' => 'question.form.city.label'
            ))
            ->add('age', IntegerType::class, array(
                'label' => 'question.form.age.label',
                'required' => false
            ))
            ->add('email', TextType::class, array('attr' => array(
                'class' => 'form-control custom',
                'placeholder' => 'question.form.mail.placeholder'
            ),
                'required' => false,
                'label' => 'question.form.mail.label'
            ))
            ->add($builder->create('date', HiddenType::class)->addViewTransformer(new DateTimeToStringTransformer()
            ))
            ->add('category', null, array(
                'label' => 'question.form.category.label',
            ));


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Question'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_question';
    }


    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options
     *
     * @deprecated since version 2.7, to be renamed in 3.0.
     *             Use the method configureOptions instead. This method will be
     *             added to the FormTypeInterface with Symfony 3.0.
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // TODO: Implement setDefaultOptions() method.
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }
}
