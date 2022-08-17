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
use App\Form\ResetPasswordType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use App\Form\FarmType;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @Route("/farm")
*/
class FarmController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    /**
     * @Route("/update", name="farm_update")
    */
    public function update(Request $request)
    {
        $form = $this->createForm(FarmType::class, $this->getUser()->getFarm())->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush();
            $this->addFlash('success', 'Les informations de votre exploitation ont ete modifie avec success');

            return $this->redirectToRoute('farm_update');
        }
        return $this->render('ui/farm/update.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
