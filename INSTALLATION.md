# Installation de NA Events 3.0.0

## 1. Sauvegarde obligatoire

```powershell
git add .
git commit -m "Sauvegarde avant multi-evenements"
```

Sauvegardez également votre base de données.

## 2. Copier les fichiers

Copiez les dossiers `app`, `database`, `resources` et `routes` dans :

`C:\laragon\www\na-events`

Acceptez le remplacement des fichiers existants.

## 3. Exécuter la migration

```powershell
C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe artisan migrate
```

Les anciens événements actifs deviennent automatiquement `published`.
Les anciens événements inactifs deviennent automatiquement `draft`.

## 4. Régénérer l'autoload

```powershell
C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe C:\laragon\bin\composer\composer.phar dump-autoload
```

## 5. Nettoyer le cache

```powershell
C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe artisan optimize:clear
```

## 6. Tests

1. Créer deux événements publiés.
2. Ajouter des sessions actives à chacun.
3. Ouvrir `/` : les deux événements doivent apparaître.
4. Cliquer sur `Voir les créneaux`.
5. Tester une réservation sur chaque événement.
6. Passer un événement en `draft` : il disparaît du public.
7. Passer un événement en `full` : il reste visible et propose la liste d'attente.
8. Passer un événement en `closed` : il disparaît du public.
9. Vérifier les PDF et exports dans l'administration.
