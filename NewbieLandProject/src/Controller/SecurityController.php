<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SecurityController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/forgot-password', name: 'app_forgot_password_request')]
    public function forgotPassword(Request $request, MailerInterface $mailer, UserRepository $userRepository): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $user = $userRepository->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash('danger', 'Cette adresse email n\'est pas associée à un compte.');
                return $this->redirectToRoute('app_forgot_password_request');
            }

            $resetLink = $this->generateUrl('app_reset_password', ['email' => $email], UrlGeneratorInterface::ABSOLUTE_URL);

            // Send email with password reset link
            $email = (new Email())
                ->from('noreply@webetdesign.com')
                ->to($email)
                ->subject('Réinitialisation de mot de passe')
                ->text("Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink")
                ->html("<p>Cliquez sur <a href=\"$resetLink\">ce lien</a> pour réinitialiser votre mot de passe.</p>");

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('error', 'Une erreur s\'est produite lors de l\'envoi de l\'email.');
                return $this->redirectToRoute('app_forgot_password_request');
            }

            $this->addFlash('success', 'Un email avec un lien de réinitialisation de mot de passe a été envoyé à votre adresse email.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/forgot_password.html.twig');
    }

    #[Route(path: '/reset-password', name: 'app_reset_password')]
    public function resetPassword(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $confirmPassword = $request->request->get('confirm_password');

            if ($password !== $confirmPassword) {
                $this->addFlash('danger', 'Les mots de passe ne correspondent pas.');
                return $this->redirectToRoute('app_reset_password', ['email' => $email]);
            }

            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash('danger', 'Cette adresse email n\'est pas associée à un compte.');
                return $this->redirectToRoute('app_reset_password', ['email' => $email]);
            }

            $user->setPassword($userPasswordHasher->hashPassword($user, $password));
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password.html.twig', ['email' => $request->query->get('email')]);
    }
}
