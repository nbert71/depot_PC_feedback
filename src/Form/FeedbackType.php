<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Feedback;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('comment')
            ->add('overall', ChoiceType::class, [
                'choices' => [
                    '0/5' => 0,
                    '1/5' => 1,
                    '2/5' => 2,
                    '3/5' => 3,
                    '4/5' => 4,
                    '5/5' => 5
                ],
                'choice_attr' => [
                    '0/5' => ['class' => 'radio-col-red'],
                    '1/5' => ['class' => 'radio-col-deep-orange'],
                    '2/5' => ['class' => 'radio-col-orange'],
                    '3/5' => ['class' => 'radio-col-yellow'],
                    '4/5' => ['class' => 'radio-col-light-green'],
                    '5/5' => ['class' => 'radio-col-green'],
                    ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('difficulty', ChoiceType::class, [
                'choices' => [
                    'Diabolique' => 5,
                    'Très difficile' => 4,
                    'Difficile' => 3,
                    'Moyen' => 2,
                    'Facile' => 1,
                    'Très facile' => 0
                ],
                'choice_attr' => [
                    'Très facile' => ['class' => 'radio-col-green'],
                    'Facile' => ['class' => 'radio-col-light-green'],
                    'Moyen' => ['class' => 'radio-col-yellow'],
                    'Difficile' => ['class' => 'radio-col-orange'],
                    'Très difficile' => ['class' => 'radio-col-deep-orange'],
                    'Diabolique' => ['class' => 'radio-col-red'],
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('interest', ChoiceType::class, [
                'choices' => [
                    'Nul' => 0,
                    'Inintéressant' => 1,
                    'Peu intéressant' => 2,
                    'Ca passe' => 3,
                    'C\'est sympa' => 4,
                    'J\'adore' => 5
                ],
                'choice_attr' => [
                    'Nul' => ['class' => 'radio-col-red'],
                    'Inintéressant' => ['class' => 'radio-col-deep-orange'],
                    'Peu intéressant' => ['class' => 'radio-col-orange'],
                    'Ca passe' => ['class' => 'radio-col-yellow'],
                    'C\'est sympa' => ['class' => 'radio-col-light-green'],
                    'J\'adore' => ['class' => 'radio-col-green'],
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('course',EntityType::class,[
                'class' => Course::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }
}
