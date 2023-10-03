<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CandidateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidate::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname'),
            TextField::new('lastname'),
            ChoiceField::new('gender')->setChoices([
                'Male' => 'm',
                'Female' => 'f',
                'Other' => 'o',
            ]),
            TextField::new('address')->onlyOnForms(),
            TextField::new('country'),
            TextField::new('nationality')->onlyOnForms(),
            DateField::new('dateOfBirth'),
            TextField::new('placeOfBirth'),
            TextField::new('location')->onlyOnForms(),
            ImageField::new('passportFile')->setUploadDir('public/uploads/passport')->onlyOnForms(),
            ImageField::new('avatarFile')->setUploadDir('public/uploads/avatar')->onlyOnForms(),
            ImageField::new('cvFile')->setUploadDir('public/uploads/cv')->onlyOnForms(),
            ChoiceField::new('experience')->setChoices([
                '0 - 6 month' => '0 - 6 month',
                '6 month - 1 year' => '6 month - 1 year',
                '1 - 2 years' => '1 - 2 years',
                '2+ years' => '2+ years',
                '5+ years' => '5+ years',
                '10+ years' => '10+ years',
            ])->onlyOnForms(),
            TextEditorField::new('description')->onlyOnForms(),
            TextEditorField::new('notes')->onlyOnForms(),
        ];
    }

}
