<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\Implementation\GenericConversionService;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use PHPUnit\Util\Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager,
                             MailerInterface $mailer,
                             GenericConversionService $genericConversionService
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $mixedValue = $form->get('plainPassword')->getData();
        try {
            $plainPassword = $genericConversionService->handleMixedToString($mixedValue) ;
        } catch (InvalidArgumentException $exception) {
            throw new Exception($exception->getMessage());
        }


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $form = $form->get('plainPassword')->getData();
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $plainPassword
                )
            );
            $user->setConfirmationToken(bin2hex(random_bytes(32)));

            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from(new Address('mailer@tvz.com', 'Super Mail Bot'))
                ->to((string)$user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
                ->context(['signedUrl' => 'http://localhost:8000/confirm-email/' . $user->getConfirmationToken()]);

            $mailer->send($email);
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/confirm-email/{token}', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, EntityManagerInterface $entityManager): Response
    {
        $token = $request->get('token');

        // Retrieve the user based on the confirmation token
        $user = $entityManager->getRepository(User::class)->findOneBy(['confirmationToken' => $token]);

        if (!$user) {
            // Handle the case where the user is not found or token is invalid
            throw $this->createNotFoundException('Invalid confirmation token or user not found.');
        }

        $user->setConfirmationToken(null);
        $user->setIsVerified(true);

        $entityManager->flush();

        return $this->redirectToRoute('app_login', ['verified' => true]);
    }
}
