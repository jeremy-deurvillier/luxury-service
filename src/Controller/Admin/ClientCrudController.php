<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\JobCategory;
use App\Entity\JobOffer;
use App\Form\JobOfferType;
use App\Repository\JobCategoryRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Clients')
            ->setPageTitle('detail', fn (Client $client) => (string) $client->getCompanyName())
            ->showEntityActionsInlined();
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('companyName')->hideOnDetail(),
            CollectionField::new('typeActivity')->allowAdd(false)->formatValue(function ($value, $entity) {
                $typesActivityToString = '';
                $typesActivity = $entity->getTypeActivity();
                $last = $typesActivity->last();

                foreach ($typesActivity as $value) {
                    if ($value === $last) {
                        $typesActivityToString .= $value->getName();
                    } else {
                        $typesActivityToString .= $value->getName() . ', ';
                    }
                }

                return $typesActivityToString;
            })->onlyOnDetail(),
            AssociationField::new('typeActivity')->autocomplete()->formatValue(function ($value, $entity) {
                $typesActivityToString = '';
                $typesActivity = $entity->getTypeActivity();
                $last = $typesActivity->last();

                foreach ($typesActivity as $value) {
                    if ($value === $last) {
                        $typesActivityToString .= $value->getName();
                    } else {
                        $typesActivityToString .= $value->getName() . ', ';
                    }
                }

                return $typesActivityToString;
            })
                /*->setQueryBuilder(
                function (QueryBuilder $queryBuilder) {
                    $list = $queryBuilder->getEntityManager()->getRepository(JobCategory::class)->findAll();
                    $r = [];

                    foreach ($list as $value) {
                        $r[] = [$value->getName() => $value->getId()];
                    }
                    //dd($r);
                    return $r;
                }
            )*/->onlyOnForms(),
            AssociationField::new('jobOffers')->autocomplete()->onlyOnForms(),
            TextField::new('contactName'),
            TextField::new('contactEmail'),
            TextField::new('contactPhone'),
            TextField::new('contactJob'),
            TextEditorField::new('notes')->hideOnIndex(),
            CollectionField::new('jobOffers')->allowAdd(true)->allowDelete(true)->onlyOnDetail(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setCreatedAt(new DateTimeImmutable());
        $entityInstance->setUpdatedAt(new DateTimeImmutable());

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedAt(new DateTimeImmutable());

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    /*public function jobCategoriesList(EntityManagerInterface $entityManager): array
    {
        $a = [];

        $repo = $entityManager->getRepository(JobCategory::class);

        $repo->createQueryBuilder('entity')
        ->where('entity.some_property = :some_value')
        ->setParameter('some_value', '...')
        ->orderBy('entity.some_property', 'ASC');

        return $a;
    }*/

    public function addJobOffer(AdminUrlGenerator $adminUrlGenerator, Request $request, AdminContext $context, EntityManagerInterface $entityManager)
    {
        //$client = $context->getEntity()->getInstance();
        //$jobOffer = new JobOffer();

        $url = $adminUrlGenerator
            ->setController(JobOfferCrudController::class)
            ->setAction(Action::NEW)
            ->generateUrl()
        ;

        dd($url);

        return $this->redirect($url);

        /*$form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobOffer->setCreatedAt(new DateTimeImmutable());
            $jobOffer->setClient($client);

            $client->addJobOffer($jobOffer);

            dd($jobOffer);

            $entityManager->persist($client);
            $entityManager->flush();
        }

        return $this->render('admin/custom-forms/add-job-offer.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);*/
    }
}
