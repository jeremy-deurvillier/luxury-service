<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Entity\JobOffer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidaciesController extends AbstractController
{
    #[Route('/candidacies/job/{id}', name: 'app_candidacies')]
    public function index(JobOffer $jobOffer, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        foreach ($this->getUser()->getCandidate()->getCandidacies() as $tempCandidacy) {
            if ($tempCandidacy->getJobOffer()->getId() === $jobOffer->getId()) {
                return $this->redirectToRoute('app_job_offer_show', ['id' => $jobOffer->getId()]);
            }
        }

        $candidate = $this->getUser()->getCandidate();
        $candidacy = new Candidacy;

        $candidacy->setCandidate($candidate);
        $candidacy->setJobOffer($jobOffer);
        $candidacy->setSubmissionDate(new DateTimeImmutable());

        $entityManager->persist($candidacy);
        $entityManager->flush();

        return $this->redirectToRoute('app_job_offer_show', ['id' => $jobOffer->getId()]);
    }
}
