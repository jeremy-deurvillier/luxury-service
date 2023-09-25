<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class JobOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Clients')
            ->setPageTitle('detail', fn (JobOffer $job) => (string) $job->getJob())
            ->showEntityActionsInlined();
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('client')->autocomplete()->formatValue(function ($value, $entity) {
                return $entity->getClient()->getCompanyName();
            }),
            BooleanField::new('active')->hideOnIndex(),
            TextField::new('reference'),
            AssociationField::new('jobCategory')->autocomplete()->formatValue(function ($value, $entity) {
                return $entity->getJobCategory()->getName();
            }),
            TextField::new('job'),
            ChoiceField::new('type')->setChoices([
                'Full time' => 'fulltime',
                'Part time' => 'parttime',
                'Temporary' => 'temporary',
                'Freelance' => 'freelance',
                'Seasonal' => 'seasonal',
            ]),
            TextField::new('location'),
            IntegerField::new('salary'),
            DateField::new('closingDate'),
            TextEditorField::new('notes'),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        //dd($entityInstance);
        $entityInstance->setCreatedAt(new DateTimeImmutable());

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
