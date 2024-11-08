# BagShare

BagShare est une plateforme privée de mise en relation pour voyageurs souhaitant rentabiliser leurs kilos de bagages inutilisés en les proposant à d’autres utilisateurs à un prix compétitif. L’objectif est de permettre aux utilisateurs de partager ou d’acheter des kilos de bagages excédentaires pour envoyer leurs affaires entre pays et continents, en toute sécurité et à moindre coût.

Les annonces sont récupérées depuis la base de données (BDD) et les utilisateurs peuvent proposer leurs kilos excédentaires ou en acheter. L’administrateur de la plateforme a un contrôle total sur la gestion des annonces et des comptes utilisateurs, tandis que les auteurs d’annonces peuvent supprimer celles qu’ils ont créées.

### Fonctionnalités principales

- **Gestion des annonces** : Les annonces des utilisateurs sont stockées dans la base de données. L’administrateur peut ajouter, modifier ou supprimer des annonces, tout comme l’auteur de l’annonce.
- **Gestion des comptes utilisateurs** : L'administrateur peut créer, modifier ou supprimer des comptes utilisateurs.
- **Avantages** : Les avantages de la plateforme sont définis dans la base de données et sont affichés pour les utilisateurs.
- **Formulaire de contact** : Le formulaire de contact permet aux utilisateurs de poser des questions ou d'exprimer leur intérêt pour rejoindre la plateforme. Les demandes sont envoyées par mail à l’administrateur.

### Exemple d'utilisation

Par exemple, un voyageur en partance pour l'Italie peut proposer 10 kg de bagages excédentaires pour 10€/kg. Un autre utilisateur, souhaitant envoyer des affaires en Italie, peut acheter ces kilos excédentaires à un prix compétitif, évitant ainsi de recourir aux services de livraison classiques.

---

## Structure du projet

Voici l'architecture de répertoires de l'application BagShare :


. ├── src │ ├── controllers │ │ ├── AuthController.php # Gestion de l'authentification des utilisateurs │ │ ├── AnnonceController.php # Gestion des annonces │ │ └── AdminController.php # Gestion de l'administration de la plateforme │ ├── models │ │ ├── User.php # Modèle des utilisateurs │ │ └── Annonce.php # Modèle des annonces │ ├── views │ │ ├── header.php # Header de la plateforme │ │ ├── footer.php # Footer de la plateforme │ │ ├── connexion.php # Page de connexion │ │ ├── annonce.php # Page d'annonce │ │ ├── admin.php # Interface d'administration │ │ └── about.php # Page "À propos" ├── public │ ├── index.php # Point d'entrée de l'application │ ├── styles │ │ └── styles.css # Fichier CSS principal │ └── data │ ├── images │ │ ├── logo5.png # Logo de la plateforme │ │ ├── globe.png # Image de globe pour la plateforme │ │ └── ... # Autres images utilisées │ └── ... ├── database │ └── maBdd.sql # Script SQL pour la création de la base de données ├── docker-compose.yml # Configuration Docker pour l'application ├── README.md # Ce fichier └── .gitignore # Fichier pour ignorer les fichiers non nécessaires dans git

yaml
Copier le code
