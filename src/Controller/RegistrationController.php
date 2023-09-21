<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\User;
use App\Form\RegistrationFormType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {

        if ($this->getUser()) {
            $isAdmin = $this->isGranted('ROLE_ADMIN');

            if ($isAdmin) return $this->redirectToRoute('admin');

            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $candidate = new Candidate();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $nickname = explode('@', $form->get('email')->getData())[0];
            $user->setNickname($nickname);

            $candidate->setAvailable(false);
            $candidate->setEmailConfirmed(false);

            $user->setCandidate($candidate);

            $user->setCreatedAt(new DateTimeImmutable());
            $user->setUpdatedAt(new DateTimeImmutable());

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            /* ***** NPO : REACTIVATE EMAIL SEND ***** */

            /*$email = (new Email())
                ->from('registration-service@luxury-service.dev.local')
                ->to($user->getEmail())
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Bienvenue sur Luxury Service !')
                //->text('Sending emails is fun again!')
                ->html('
                    <h1>Bravo vous avez réussi !</h1>
                    <p>Vous êtes maintenant membre de Luxury Service.</p>
                ');

            $mailer->send($email);*/

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
