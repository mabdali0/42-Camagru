# Camagru

## Résumé
L'objectif de ce projet est de construire une application web qui permet aux utilisateurs de créer, éditer et partager des images en utilisant une webcam et des superpositions prédéfinies.

## Contenu
1. [Introduction](#introduction)
2. [Objectifs](#objectifs)
3. [Instructions Générales](#instructions-générales)
4. [Partie Obligatoire](#partie-obligatoire)
    - [Fonctionnalités Communes](#fonctionnalités-communes)
    - [Fonctionnalités Utilisateur](#fonctionnalités-utilisateur)
    - [Fonctionnalités de la Galerie](#fonctionnalités-de-la-galerie)
    - [Fonctionnalités d'Édition](#fonctionnalités-dédition)
    - [Contraintes et Éléments Obligatoires](#contraintes-et-éléments-obligatoires)
5. [Partie Bonus](#partie-bonus)

---

## Introduction
Avec ce projet, vous apprendrez à construire une application web qui utilise des technologies web modernes. Le projet vise à vous familiariser avec le design réactif, la manipulation du DOM et les mesures de sécurité.

## Objectifs
Le projet demande de créer une petite application web qui permet aux utilisateurs de faire des modifications photo de base en utilisant leur webcam et des images prédéfinies avec transparence.

## Instructions Générales
- Suivre l'architecture MVC.
- S'assurer que l'application web n'a pas d'erreurs ou d'avertissements dans la console.
- Valider tous les formulaires et sécuriser l'application contre les vulnérabilités courantes.
- Utiliser PHP pour la logique côté serveur et HTML, CSS, et JavaScript pour le développement côté client.

## Partie Obligatoire

### Fonctionnalités Communes
- L'application web doit avoir une structure de mise en page (en-tête, section principale, pied de page).
- Assurer le responsive mobile.
- Implémenter des validations de formulaire et garantir la sécurité générale du site.

### Fonctionnalités Utilisateur
- Les utilisateurs peuvent s'inscrire avec une adresse e-mail valide, un nom d'utilisateur et un mot de passe complexe ou aussi un compte intra 42.
- Confirmation de compte par un lien unique envoyé par e-mail.
- Les utilisateurs peuvent se connecter, réinitialiser leur mot de passe et se déconnecter.
- Modifications du profil (nom d'utilisateur, e-mail, mot de passe, nom, prénom) sont autorisées.

### Fonctionnalités de la Galerie
- Galerie publique affichant toutes les images postées par ordre chronologique.
- Les utilisateurs connectés peuvent aimer et commenter les images.
- Notification par e-mail aux auteurs d'images lorsqu'un nouveau commentaire est posté.
- Pagination pour l'affichage des images.

### Fonctionnalités d'Édition
- Accessibles uniquement aux utilisateurs qui ont validé leur email.
- Section principale avec aperçu de la webcam, superpositions sélectionnables et bouton de capture.
- Option d'upload d'image pour les utilisateurs sans webcam.
- Les utilisateurs peuvent supprimer leurs propres images éditées.

### Contraintes et Éléments Obligatoires
- La logique côté serveur doit utiliser le language standard PHP.
- Le côté client doit utiliser HTML, CSS et JavaScript (les frameworks CSS sont tolérés).
- Déploiement via des conteneurs (ex. : docker-compose).

## Partie Bonus
- Fonctionnalités AJAX.
- Aperçu en direct du like ou commentaire ajouté.
- Pagination infinie pour la galerie.
- Supprimer un compte utilisateur
- La page mes posts qui pagine uniquement les posts de l'utilisateur connecté