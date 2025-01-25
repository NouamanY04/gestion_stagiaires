# README

## Description
Cette application gère les informations des stagiaires, incluant leur ajout, modification, recherche et suppression. Les stagiaires ont des données associées comme le nom, le prénom, le groupe, les compétences et une image .

## Fonctionnalités
- Ajouter des stagiaires avec leurs informations et avatar.
- Modifier les informations d'un stagiaire existant.
- Rechercher des stagiaires par nom, prénom ou groupe.
- Supprimer un stagiaire, y compris son avatar.
- Les avatars des stagiaires sont enregistrés dans le dossier `pictures`.

## Bibliothèques et Technologies
- **PHP** : Utilisé pour le traitement côté serveur.
- **JavaScript** : Pour les interactions côté client.
- **MySQL** : Base de données pour stocker les informations des stagiaires.
- **yoyoPopup** : Bibliothèque JavaScript pour afficher des popups.

## Installation
1. Clonez le projet sur votre serveur local :
   ```bash
   git clone https://github.com/NouamanY04/gestion_stagiaires.git
   ```

## Utilisation
### Ajouter un Stagiaire
- Remplissez le formulaire d'ajout avec les informations nécessaires.
- Ajoutez une image d'avatar.

### Rechercher un Stagiaire
- Utilisez la barre de recherche pour trouver un stagiaire par **nom**, **prénom**, ou **groupe**.
- La recherche est dynamique et retourne les résultats correspondants.

### Supprimer un Stagiaire
- Cliquez sur "Supprimer" dans la liste des résultats de recherche pour effacer un stagiaire.
- L'image associée à l'étudiant est également supprimée du dossier `pictures`.

