# BagShare
Avec BagShare partager vos kilos de bagages en toutes sécurité. 
BagShare est une plateforme de mise en relation pour voyageurs souhaitant rentabiliser leurs kilos de bagages inutilisés en les proposant à d’autres utilisateurs à un prix compétitif. Les utilisateurs peuvent acheter ces kilos pour envoyer leurs affaires entre pays et continents, en toute sécurité et à moindre coût. Par exemple, un voyageur en partance pour l'Italie peut mettre à disposition ses kilos excédentaires pour 10€/kilo. BagShare offre une alternative aux services de livraison classiques, plus flexible et économique.


# structure du projet
.
├── src
│   ├── controllers
│   │   ├── AuthController.php
│   │   ├── AnnonceController.php
│   │   └── AdminController.php
│   ├── models
│   │   ├── User.php
│   │   └── Annonce.php
│   ├── views
│   │   ├── header.php
│   │   ├── footer.php
│   │   ├── connexion.php
│   │   ├── annonce.php
│   │   ├── admin.php
│   │   └── about.php
├── public
│   ├── index.php
│   ├── styles
│   │   └── styles.css
│   └── data
│       ├── images
│       │   ├── logo5.png
│       │   ├── globe.png
│       │   └── ...
│       └── ...
├── database
│   └── maBdd.sql
├── docker-compose.yml
├── README.md
└── .gitignore
