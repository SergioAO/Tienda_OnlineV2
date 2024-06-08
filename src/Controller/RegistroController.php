<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\RegistroFormType;
use App\Repository\UsuarioRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistroController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/registro', name: 'app_registro')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Usuario();
        $form = $this->createForm(RegistroFormType::class, $user);
        $form->handleRequest($request);
        $plaintextPassword = $form->get('plainPassword')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );

            $user->setPassword($hashedPassword);

            $nombre = $form->get('nombre')->getData();
            if ($nombre) {
                $user->setNombre($nombre);
            }
            $apellidos = $form->get('apellidos')->getData();
            if ($apellidos) {
                $user->setApellidos($apellidos);
            }
            $foto = $form->get('photo')->getData();
            if ($foto) {
                $originalFilename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$foto->guessExtension();

                // Mover el archivo a la carpeta de subidas
                try {
                    $foto->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $user->setPhoto($newFilename);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@electro-gamer.es', 'Electro Gamer'))
                    ->to($user->getEmail())
                    ->subject('Por favor confirma tu cuenta')
                    ->htmlTemplate('registro/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email
            return $this->redirectToRoute('app_login');
        }
        return $this->render('registro/index.html.twig', [
            'registroForm' => $form->createView(),
        ]);
    }

    #[\Symfony\Component\Routing\Attribute\Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, Usuario::class->getUsuario());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Tu dirección de email ha sido verificada.');

        return $this->redirectToRoute('app_register');
    }
}
