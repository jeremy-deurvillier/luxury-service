<?php

namespace App\Form;

use App\Entity\JobOffer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // dd();

        $choices = [
            'Full time' => 'fulltime',
            'Part time' => 'parttime',
            'Temporary' => 'temporary',
            'Freelance' => 'freelance',
            'Seasonal' => 'seasonal',
        ];

        $builder
            ->add('reference', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('active', CheckboxType::class, ['required' => false, 'attr' => ['checked' => true]])
            ->add('job', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('type', ChoiceType::class, [
                'choices' => $choices, 
                'attr' => ['class' => 'form-select tomselected']
            ])
            ->add('location', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('salary', IntegerType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('notes', TextareaType::class, [
                'required' => false,
                'attr' => ['class' => 'ea-text-editor-content form-control']
            ])
            //->add('createdAt')
            ->add('closingDate', DateType::class, ['required' => false])
            ->add('jobCategory', ChoiceType::class, ['attr' => ['class' => 'form-select tomselected']])
            //->add('clients')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobOffer::class,
        ]);
    }
}
