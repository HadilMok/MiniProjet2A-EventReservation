# MiniProjet2A - EventReservation (FIA3-GL)

## Étudiant
- **Nom :** Hadil Mokni
- **Classe :** FIA3-GL

## Description
Application de gestion de réservations d'événements avec sécurité renforcée.

## Fonctionnalités Clés
- **Backend :** Symfony 7 & MariaDB.
- **Sécurité :** JWT (LexikBundle) & Passkeys (WebAuthn) pour l'admin.
- **Logique :** Décrémentation automatique des places et confirmation par mail.
- **Tests :** Tests unitaires et fonctionnels avec PHPUnit.
- **DevOps :** Docker-compose (PHP, Nginx, MariaDB).

## Installation
1. `git clone https://github.com/HadilMok/MiniProjet2A-EventReservation.git`
2. `docker-compose up -d`
3. `composer install`
4. `php bin/console doctrine:migrations:migrate`

## Accès
- **Public :** `/events`
- **Admin :** `/admin/dashboard` (Sécurisé par JWT/Passkey)
