## Installation PHP 8.3, PHP8.3-FPM, composer et les dépendances PHP

### Étape 1 : Préparation de l'installation
Installez le paquet nécessaire pour ajouter un nouveau dépôt :<br>
```sudo apt install software-properties-common -y```

### Étape 2 : Ajout du dépôt PPA pour PHP
Ajoutez le dépôt PPA maintenu par Ondřej Surý pour les versions récentes de PHP :<br>
```sudo add-apt-repository ppa:ondrej/php -y```

### Étape 3 : Mise à jour de la liste des paquets
Mettez à jour les informations des paquets disponibles :<br>
```sudo apt update```

### Étape 4 : Installation de PHP 8.3 et des extensions
Installez PHP 8.3 ainsi que les extensions nécessaires pour votre application :<br>
```sudo apt install php8.3 php8.3-fpm php8.3-xml imagemagick php-imagick php8.3-curl php8.3-gd php8.3-zip php-intl php-mysql -y```

### Étape 5 : Vérification du statut de PHP-FPM
Vérifiez le statut du service PHP-FPM :<br>
```sudo service php8.3-fpm status```

### Étape 6 : Démarrage de PHP-FPM si nécessaire
Si le service n'est pas actif, démarrez-le :<br>
```sudo service php8.3-fpm start```

### Étape 7 : Installation de Composer
Installez Composer, un outil de gestion de dépendances pour PHP :<br>
```curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer```

### Étape 8 : Redémarrage de PHP-FPM
Assurez-vous que toutes les nouvelles configurations sont prises en compte en redémarrant PHP-FPM :<br>
```sudo service php8.3-fpm restart```

[Retour à la page d'accueil](../README.md)<br>
[Suite](php-config.md)