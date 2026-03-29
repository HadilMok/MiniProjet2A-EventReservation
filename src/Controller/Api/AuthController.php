<?php
namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/auth')]
class AuthController extends AbstractController
{
    #[Route('/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setUsername($data['username']);
        $user->setPassword($hasher->hashPassword($user, $data['password']));

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['message' => 'User registered successfully'], 201);
    }

    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        return new JsonResponse(['message' => 'Login handled by JWT firewall']);
    }

    #[Route('/me', name: 'api_me', methods: ['GET'])]
    public function me(): JsonResponse
    {
        return new JsonResponse([
            'username' => $this->getUser()->getUserIdentifier(),
            'roles' => $this->getUser()->getRoles(),
        ]);
    }
}
