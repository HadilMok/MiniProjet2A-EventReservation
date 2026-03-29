<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/api/passkey/options', name: 'api_passkey_options', methods: ['POST'])]
    public function passkeyOptions(\Symfony\Component\HttpFoundation\Request $request, \App\Service\PasskeyAuthService $passkeyService): \Symfony\Component\HttpFoundation\JsonResponse
    {
        // Conforme FIA3-GL : Simulation de génération de challenge
        return $this->json(['options' => 'webauthn_challenge_generated_successfully']);
    }
}
