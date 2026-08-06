# Changelog 3.0.0

## Ajouté
- statut complet des événements
- page publique multi-événements
- page publique dédiée par événement
- route publique basée sur le slug
- filtrage des événements visibles
- compatibilité liste d'attente par événement

## Modifié
- modèle Event
- EventService
- SaveEventRequest
- EventController
- HomeController
- ReservationController
- formulaire d'événement
- page d'accueil
- routes

## Migration
- ajout de `events.status`
- conversion automatique de `is_active`

## Non modifié
- PDF
- exports Excel
- présences
- administration des sessions
- paramètres globaux
