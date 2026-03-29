# EventReservation - FIA3-GL

## Auteur
**Hadil Mokni**

## Technologies
- **Framework:** Symfony 7
- **Sécurité:** JWT & WebAuthn (Passkeys)
- **Base de données:** MariaDB
- **Conteneurisation:** Docker & Docker Compose

## Installation avec Docker
1. `docker compose up -d --build`
2. `docker compose exec php composer install`
3. `docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction`

## Fonctionnalités
- Liste d'événements avec design Bootstrap 5.
- Système de réservation (décrémentation des places).
- Simulation d'authentification sans mot de passe (Passkeys).
