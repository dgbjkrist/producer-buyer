<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ForgottenPasswordInput;
use App\Entity\Customer;
use App\Entity\ForgottenPassword;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Producer;
use App\Form\ForgottenPasswordType;
use App\Form\RegistrationForm;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration/{role}", name="security_registration")
     */
    public function registration(
        string $role,
        Request $request,
        UserPasswordEncoderInterface $userPasswordEncoderInterface
    ): Response {
        $user = Producer::ROLE === $role ? new Producer() : new Customer();
        $form = $this->createForm(RegistrationForm::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordEncoderInterface->encodePassword($user, $form->get('plainPassword')->getData())
            );
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Votre inscription a été effectué avec succes");

            return $this->redirectToRoute("index");
        }

        return $this->render('ui/security/registration.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('ui/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(Request $request)
    {
//        $request->getSession()->getFlashBag()->add('info', 'Deconnection reussie '.$this->getUser()->getEmail());
        throw new \LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }

    /**
     * @Route("/forgotten-password", name="security_forgotten_password")
     */
    public function forgottenPassword(Request $request, UserRepository $userRepository, MailerInterface $mailerInterface)
    {
        $forgottenPasswordInput = new ForgottenPasswordInput();

        $form = $this->createForm(ForgottenPasswordType::class, $forgottenPasswordInput)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var User $user */
            $user = $userRepository->findOneByEmail($forgottenPasswordInput->getEmail());
            $user->hasForgotHisPassword();
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $email = (new TemplatedEmail())
                        ->to(new Address($user->getEmail(), $user->getFullName()))
                        ->from("hello@producerbuyer.com")
                        ->context(["forgottenPassword" => $user->getForgottenPassword()])
                        ->htmlTemplate('emails/forgotten_password.twig')
            ;

            $mailerInterface->send($email);

            $this->addFlash("success", "Votre demande d'oublie de mot de passe a bien été enregistré.
            vous allez recevoir un email pour reinitialiser votre mot de passe");

            return $this->redirectToRoute("security_login");
        }
        return $this->render('ui/security/forgotten_password.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/reset-password/{token}", name="security_reset_password")
     */
    public function resetPassword(): Response
    {
        return $this->render('$0.html.twig', []);
    }
}
