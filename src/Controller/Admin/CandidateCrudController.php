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
            TextField::new('address'),
            TextField::new('country'),
            TextField::new('nationality'),
            DateField::new('dateOfBirth'),
            TextField::new('placeOfBirth'),
            TextField::new('location'),
            ImageField::new('passportFile')->setUploadDir('public/uploads/private/passports'),
            ImageField::new('avatarFile')->setUploadDir('public/uploads/private/avatars'),
            ImageField::new('cvFile')->setUploadDir('public/uploads/private/cv'),
            ChoiceField::new('experience')->setChoices([
                '0 - 6 month' => '0 - 6 month',
                '6 month - 1 year' => '6 month - 1 year',
                '1 - 2 years' => '1 - 2 years',
                '2+ years' => '2+ years',
                '5+ years' => '5+ years',
                '10+ years' => '10+ years',
            ]),
            TextEditorField::new('description'),
            TextEditorField::new('notes'),
        ];
    }

}
