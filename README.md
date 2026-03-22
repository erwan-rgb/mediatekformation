# README – MediatekFormation (version étendue)

## Dépôt d’origine
Le dépôt d’origine du projet est disponible ici :
https://github.com/CNED-SLAM/mediatekformation
Il contient la présentation complète de l’application initiale (fonctionnement, pages, BDD, captures, etc.).
Le présent dépôt documente uniquement les fonctionnalités ajoutées, ainsi que le mode opératoire pour installer et utiliser l’application.

## Fonctionnalités ajoutées

### 1. Nettoyage du code avec SonarLint

* Correction des balises HTML (strong, em, alt, caption, etc.)
* Normalisation des constantes
* Suppression des duplications de chaînes
* Fusion de conditions imbriquées
* Amélioration générale de la lisibilité du code <br>
<img width="1148" height="86" alt="Capture d&#39;écran 2026-02-22 152908" src="https://github.com/user-attachments/assets/d2aa012d-dc2c-4769-abc1-fa8750812b57" />

### 2. Ajout du nombre de formations par playlist + tri

* Nouvelle colonne “Nombre de formations” dans la page playlists
* Tri croissant/décroissant sur cette colonne
* Affichage du nombre de formations dans la page détail d’une playlist
* Ajout d’une méthode dédiée dans le repository (findOrder())

### 3. Back-office : CRUD Formations

* Interface d’administration complète
* Création / modification / suppression d’une formation
* Upload de vidéos via VichUploader
* Formulaire Symfony dédié (FormationType)
* Pages Twig dédiées

### 4. Back-office : CRUD Playlists

* Gestion complète des playlists
* Création / modification / suppression
* Formulaire Symfony (PlaylistType)
* Pages Twig dédiées

### 5. Back-office : CRUD Catégories

* Ajout / suppression de catégories
* Vérification métier (suppression impossible si utilisée)

### 6. Authentification du back-office

* Page de connexion sécurisée
* Accès réservé au rôle ROLE_ADMIN
* Déconnexion accessible depuis toutes les pages admin

### 7. Mise en place des tests

* Tests unitaires
* Tests d’intégration
* Tests fonctionnels
* Tests navigateurs (Chrome, Edge, Brave)

### 8. Documentation technique

* Génération automatique via phpDocumentor
* Documentation disponible dans /public/docs

### 9. Documentation utilisateur (vidéo) 

* Vidéo de présentation de moins de 5 minutes
* Navigation, fonctionnalités, back-office, tri, filtres

### 10. Déploiement du site 

* Déploiement complet sur AlwaysData
* Configuration PHP, BDD, migrations
* Mise à jour des CGU avec l’URL de production
* Mise en ligne de la documentation technique

### 11. Sauvegarde quotidienne automatisée 

* Script backup.sh
* Dump SQL compressé chaque jour à 12h30
* Restauration possible via SSH

### 12. Déploiement continu 

* Workflow GitHub Actions
* Déploiement automatique via FTP à chaque push sur main
* Secret GitHub pour le mot de passe FTP
* Synchronisation automatique des fichiers


## Installation en local 

### 1. Prérequis

* PHP 8.3
* Composer
* MySQL
* Symfony CLI (optionnel mais recommandé)
* WampServer

### 2. Récupérer le projet 

Vous pouvez récupérer le projet en téléchargeant l’archive ZIP depuis GitHub : <br> <br>
&nbsp;&nbsp;&nbsp;  1. Aller sur le dépôt GitHub <br>
&nbsp;&nbsp;&nbsp; 2.  Cliquer sur **Code** <br>
&nbsp;&nbsp;&nbsp; 3. Cliquer sur **Download ZIP** <br>
&nbsp;&nbsp;&nbsp; 4. Décompresser l’archive <br>
&nbsp;&nbsp;&nbsp; 5. Placer le dossier du projet dans : <br>
        &nbsp;&nbsp;&nbsp;&nbsp; C:\wamp64\www\mediatekformation

### 3. Installer les dépendances

**composer install**

### 4. Configurer l’environnement 

Créer un fichier .env.local :
**DATABASE_URL="mysql://user:password@127.0.0.1:3306/mediatekformation"**

 Ne jamais mettre ce fichier dans Git.

 ### 5. Créer la base de données
 
La base de données peut être créée directement via phpMyAdmin : <br>

   1. Ouvrir **phpMyAdmin**
   2. Se connecter à MySQL
   3.  Créer une base de données nommée **mediatekformation**
   4.  Importer le fichier **mediatekformation.sql** situé à la racine du projet


### 6. Lancer le serveur (WampServer)

Si vous utilisez WampServer, il n’est pas nécessaire d’utiliser symfony serve.
Le projet se lance directement via Apache.

#### Étapes : 

1. Démarrer WampServer <br>
    * L’icône doit devenir verte (Apache + MySQL OK)
    
2. Placer le projet dans : <br>
    * C:\wamp64\www\mediatekformation

3. Vérifier que le dossier contient bien : <br>
    * /public
    *  /src
    * /vendor (créé après composer install)

4. Ouvrir l’application dans un navigateur : <br>
    * http://localhost/mediatekformation/public/

 #### Résultat 

 L’application Symfony fonctionne maintenant via Apache, comme un site classique.
 

## Tester l’application en ligne 

L’application est disponible ici : 
**https://voyageenpoche.alwaysdata.net**

Fonctionnalités testables :

* Navigation (accueil, formations, playlists)
* Tri et filtres
* Pages détail
* Documentation technique (/docs)

Les identifiants admin ne sont pas fournis ici (voir fiche séparée).


## Structure du projet 

/src <br>
/templates <br>
/public <br>
/tests <br>
/config <br>
/docs












 
