<?php

namespace App\Controller;

use App\Form\CandidateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser() && $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        }

        $user = $this->getUser()->getCandidate();
        $form = $this->createForm(CandidateType::class, $user);

        $form->handleRequest($request);

        $rateCompletion = 0;
        $numberOfFieldsNoEmpty = 0;

        // Tableau pour lister les champs comptabilisés dans le pourcentage de complétion du formulaire.
        $userFields = [
            'firstname' => $user->getFirstName(),
            'lastname' => $user->getLastName(),
            'gender' => $user->getGender(),
            'address' => $user->getAddress(),
            'country' => $user->getCountry(),
            'nationality' => $user->getNationality(),
            'date_of_birth' => $user->getDateOfBirth(),
            'place_of_birth' => $user->getPlaceOfBirth(),
            'location' => $user->getLocation(),
            'passport_file' => $user->getPassportFile(),
            'avatar_file' => $user->getAvatarFile(),
            'cv_file' => $user->getCvFile(),
            'experience' => $user->getExperience(),
            'description' => $user->getDescription(),
            'available' => $user->isAvailable(),
        ];

        $totalFields = count($userFields);

        foreach ($userFields as $field) {
            if ($field !== null) $numberOfFieldsNoEmpty += 1;
        }

        $rateCompletion = ($numberOfFieldsNoEmpty * 100) / $totalFields;

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form['avatarFile']->getData()) {
                $avatarFile = $form['avatarFile']->getData();
                $avatarNameFile = $this->uploadFile($avatarFile, 'avatar');

                $user->setAvatarFile($avatarNameFile);
            }

            if ($form['cvFile']->getData()) {
                $cvFile = $form['cvFile']->getData();
                $cvNameFile = $this->uploadFile($cvFile, 'cv');

                $user->setcvFile($cvNameFile);
            }

            if ($form['passportFile']->getData()) {
                $passportFile = $form['passportFile']->getData();
                $passportNameFile = $this->uploadFile($passportFile, 'passport');

                $user->setPassportFile($passportNameFile);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/index.html.twig', [
            'rateCompletion' => $rateCompletion,
            'form' => $form,
        ]);
    }

    /* ** Sauvegarde le fichier sur le serveur.
    * @return Le nom du fichier, avec son extension.
    */
    private function uploadFile($file, $prefixe)
    {
        $name = md5($this->getUser()->getEmail());
        $extension = $file->guessExtension();
        $finalName = $prefixe . '-' . $name . '.' . $extension;

        $file->move('uploads/' . $prefixe, $finalName);

        return $finalName;
    }
}
