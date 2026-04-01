<?php
namespace App\Service;

use App\Entity\User;

class PasskeyAuthService
{
    public function getRegistrationOptions(User $user): array
    {
        // Structure de données conforme au standard FIDO2 / WebAuthn
        return [
            'challenge' => base64_encode(random_bytes(32)),
            'rp' => [
                'name' => 'EventReservation',
                'id' => 'localhost'
            ],
            'user' => [
                'id' => (string)$user->getId(),
                'name' => $user->getEmail(),
                'displayName' => $user->getEmail(),
            ],
            'pubKeyCredParams' => [
                ['type' => 'public-key', 'alg' => -7], // ES256
                ['type' => 'public-key', 'alg' => -257], // RS256
            ],
            'timeout' => 60000,
            'attestation' => 'none',
        ];
    }
}
