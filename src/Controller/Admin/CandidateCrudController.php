<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

class CandidateCrudController extends AbstractCrudController
{
    private $sanitize = null;

    public function __construct(HtmlSanitizerInterface $sanitize)
    {
        $this->sanitize = $sanitize;
    }

    public static function getEntityFqcn(): string
    {
        return Candidate::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
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
            TextareaField::new('description')->hideOnIndex(),
            TextareaField::new('notes')->onlyOnForms(),
        ];
    }

}
