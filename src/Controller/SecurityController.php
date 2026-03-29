<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('Intercepted by firewall.');
    }
}

    #[Route('/api/passkey/options', name: 'api_passkey_options', methods: ['POST'])]
    public function passkeyOptions(\Symfony\Component\HttpFoundation\Request $request, \App\Service\PasskeyAuthService $passkeyService): \Symfony\Component\HttpFoundation\JsonResponse 
    {
        // Dans un flux réel, on identifierait l'utilisateur ici
        return $this->json(['options' => 'webauthn_challenge_generated_successfully']);
    }
