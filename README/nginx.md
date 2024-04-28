## Installation de Nginx

Cette section guide à travers les étapes d'installation et de configuration de Nginx sur votre serveur. Suivez chaque étape soigneusement pour assurer une installation correcte.

### Étape 1: Installation de Nginx
Installez Nginx en utilisant la commande suivante :<br>
```sudo apt install nginx -y```

### Étape 2: Démarrage de Nginx
Démarrez le service Nginx avec la commande suivante :<br>
```sudo service nginx start```

### Étape 3: Vérification de Nginx
Vérifiez que Nginx fonctionne correctement en recherchant les processus actifs :<br>
```ps aux | grep nginx```

### Étape 4: Arrêt d'Apache
Si Apache est encore actif et que vous voyez la page d'Apache sur http://localhost, arrêtez le service avec :<br>
```sudo service apache2 stop```<br>
Désactivez le démarrage automatique d'Apache :<br>
```sudo update-rc.d apache2 disable```

### Étape 5: Redémarrage de Nginx
Redémarrez Nginx pour appliquer les modifications :<br>
```sudo service nginx restart```

### Étape 6: Vérification du port d'écoute
Assurez-vous que Nginx écoute sur le port 80 :<br>
```sudo netstat -tulnp | grep :80```

### Étape 7: Suppression d'Apache
Si Apache n'est plus nécessaire, vous pouvez le désinstaller complètement :<br>
```sudo apt remove --purge apache2 apache2-utils apache2.2-bin -y```<br>
```sudo apt autoremove -y```

### Confirmation
Si toutes les étapes ont été correctement suivies, vous devriez voir la page par défaut de Nginx s'afficher sur http://localhost.

[Retour à la page d'accueil](../README.md)<br>
[Suite](php-fpm.md)