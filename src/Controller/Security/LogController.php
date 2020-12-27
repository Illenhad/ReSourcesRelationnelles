<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Form\SendEmailPasswordType;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LogController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/forgot_password", name="forgotPassword")
     *
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function forgotPassword(Request $request, UserRepository $userRepository, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        //création du formulaire
        $form = $this->createForm(SendEmailPasswordType::class);

        $form->handleRequest($request);

        //si le form est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $userRepository->findOneBy(['email' => $data['email']]);
            //si l'utilisateur n'existe pas
            if (null === $user) {
                $form->addError(new FormError('Cette adresse mail n\'existe pas'));
            } else {
                $token = $tokenGenerator->generateToken();

                $user->setTokenRecup($token);
                $entitymanager = $this->getDoctrine()->getManager();
                $entitymanager->persist($user);
                $entitymanager->flush();

                $url = $this->generateUrl('reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
                $message = (new TemplatedEmail())
                    ->from('noreply@ReSourcesRelationnelles.com')
                    ->to($user->getEmail())
                    ->subject('Mot de passe oublié')
                    ->htmlTemplate('email/ForgotPassword.html.twig')
                    ->context(['user' => $user,
                        'url' => $url, ]);
                $mailer->send($message);
            }
        }

        return $this->render('security/forgotPassword.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/forgot_password/{token}", name="reset_password")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ResPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['token_recup' => $token]);
        // Si l'utilisateur n'existe pas
        if (null == $user) {
            // On affiche une erreur
            $this->addFlash('danger', 'Token Inconnu');

            return $this->redirectToRoute('login');
        }
        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($data['password'] == $data['confirm_password']) {
                try {
                    // On supprime le token
                    $user->setTokenRecup(null);

                    // On chiffre le mot de passe
                    $hash = $passwordEncoder->encodePassword($user, $data['password']);
                    $user->setPassword($hash);

                    // On stocke
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    // On redirige vers la page de connexion
                    return $this->redirectToRoute('login');
                } catch (\Exception $e) {
                    $form->addError(new FormError('Une erreur c\'est produite'.$e));
                }
            } else {
                $form->addError(new FormError('Votre mot de passe doit être le même que celui que vous confirmez'));
            }
        }

        return $this->render('security/reset_password.html.twig', ['token' => $token, 'form' => $form->createView()]);
    }
}
