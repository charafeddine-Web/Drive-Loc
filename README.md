# Drive & Loc - Système de Gestion de Location de Voitures

## Contexte du Projet
L'agence **Drive & Loc** souhaite enrichir son site web en proposant un système de gestion de location de voitures.

L'objectif est de créer une plateforme créative et fonctionnelle permettant aux clients de parcourir et réserver des véhicules selon leurs besoins.

Ce projet a été développé en utilisant **PHP POO** et **SQL** pour garantir robustesse et maintenabilité.
---
## User Stories

### Côté Client
- 🚗 **Connexion**: En tant que client, je dois me connecter pour accéder à la plateforme de location.
- 🏍️ **Exploration**: En tant que client, je peux explorer les différentes catégories de véhicules disponibles.
- 🚗 **Détails des Véhicules**: En tant que client, je peux cliquer sur un véhicule pour afficher ses détails (modèle, prix, disponibilité, etc.).
- 🛣️ **Réservation**: En tant que client, je peux réserver un véhicule en précisant les dates et lieux de prise en charge.
- 🔎 **Recherche**: En tant que client, je peux rechercher un véhicule spécifique par son modèle ou ses caractéristiques.
- 🏍️ **Filtrage Dynamique**: En tant que client, je peux filtrer les véhicules disponibles par catégorie sans avoir à rafraîchir la page.
- 📝 **Avis et Évaluations**: En tant que client, je peux ajouter un avis ou une évaluation sur un véhicule que j'ai loué.
- 🏦 **Pagination**: En tant que client, je peux lister les véhicules disponibles par pages (pagination).
    - 🚙 **Version 1**: Pagination à l'aide de PHP.
    - 🚙🚙 **Version 2**: Utiliser DataTable pour une gestion interactive et dynamique de la pagination.
- 🚙 **Gestion des Avis**: En tant que client, je peux modifier ou supprimer mes propres avis (Soft Delete).

### Côté Administrateur
- 🏦 **Ajout en Masse**: En tant qu'administrateur, je peux ajouter plusieurs véhicules ou catégories à la fois (insertion en masse).
- 🚨 **Gestion Globale**: En tant qu'administrateur, je peux gérer les réservations, les véhicules, les avis, et les catégories avec des statistiques via un **Dashboard Admin**.
---
## Fonctionnalités Avancées
### Extra
- **Vue SQL**: Création d'une vue SQL "ListeVehicules" combinant les informations nécessaires pour afficher la liste des véhicules, y compris les détails des catégories, les évaluations associées et leur disponibilité.
- **Procédure Stockée**: Création d'une procédure stockée "AjouterReservation" prenant en compte les paramètres nécessaires pour réaliser une réservation sur un véhicule spécifique.
### Bonus
- 🏆 **Validation des Réservations**: En tant qu'administrateur, je peux approuver ou refuser les réservations en envoyant un email au client concerné.
- 🌟 **Options Supplémentaires**: En tant que client, je peux ajouter des options supplémentaires (GPS, siège enfant, etc.) lors de la réservation.
- 🏅 **Interactions sur les Avis**: En tant que client, je peux liker ou disliker un avis donné.
- 🏅 **Favoris**: En tant que client, je peux marquer un véhicule comme favori pour des réservations futures.
- 🏅 **Statistiques**: En tant que client, je peux accéder à des statistiques sur les véhicules les plus réservés et les mieux évalués.
- 🏅 **Validation au Niveau SQL**: Validation des champs au niveau de la base de données via un trigger SQL.
- 🏅 **Gestion des Clients**: En tant qu’administrateur, je peux accéder à une page dédiée à la gestion des clients.

---
## Technologies Utilisées
- **Langages**: PHP (POO,PDO), SQL
- **Base de Données**: MySQL
- **Frontend**: HTML5, CSS3(tailwind), JavaScript 

---

## Installation
1. Clonez le dépôt :
   ```bash
   git clone <https://github.com/charafeddine-Web/Drive-Loc.git>
   ```
2. Configurez la base de données en important le fichier `schema.sql` dans votre serveur MySQL.
3. Configurez les identifiants de connexion à la base de données dans le fichier `config.php`.
4. Lancez le projet sur votre serveur local (XAMPP/WAMP ou autre).

---

## Auteur
**[Tbibzat Charaf Eddine]**
---
