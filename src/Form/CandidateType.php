<?php

namespace App\Form;

use App\Entity\Candidate;
use App\Entity\JobCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, ['required' => false])
            ->add('lastname', TextType::class, ['required' => false])
            ->add('gender', ChoiceType::class, [
                'required' => false,
                'choices'  => [
                    'Choose an option...' => null,
                    'Male' => 'm',
                    'Female' => 'f',
                    'Other' => 'o',
                ],
            ])
            ->add('address', TextType::class, ['required' => false])
            ->add('country', TextType::class, ['required' => false])
            ->add('nationality', TextType::class, ['required' => false])
            ->add('dateOfBirth', BirthdayType::class, ['required' => false])
            ->add('placeOfBirth', TextType::class, ['required' => false])
            ->add('location', TextType::class, ['required' => false])
            ->add('passportFile', FileType::class, ['required' => false])
            ->add('avatarFile', FileType::class, ['required' => false, 'mapped' => false])
            ->add('cvFile', FileType::class, ['required' => false])
            ->add('experience', ChoiceType::class, [
                'required' => false,
                'choices'  => [
                    'Choose' => null,
                    '0 - 6 month' => '0 - 6 month',
                    '6 month - 1 year' => '6 month - 1 year',
                    '1 - 2 years' => '1 - 2 years',
                    '2+ years' => '2+ years',
                    '5+ years' => '5+ years',
                    '10+ years' => '10+ years',
                ],
            ])
            ->add('description', TextType::class, ['required' => false])
            //->add('notes')
            //->add('emailConfirmed')
            //->add('available', CheckboxType::class, ['attr' => ['required' => false]])
            ->add('jobCategories', CollectionType::class, [
                'required' => false,
                'entry_type' => JobCategoryType::class,
                'entry_options' => ['label' => true],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
