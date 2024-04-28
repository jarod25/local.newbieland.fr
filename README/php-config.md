## Configuration PHP à modifier

### Étape 1 : Modifier les permissions de manière sécurisée
Mettre à jour les permissions pour les fichiers qu'il faudra modifier :  <br>
```sudo chmod 777 /etc/hosts``` <br>
```sudo chmod 777 /etc/php/8.3/fpm/php.ini``` <br>
```sudo chmod 777 /etc/php/8.3/fpm/pool.d/www.conf``` <br>

### Étape 2 : Modification du fichier php.ini
Ouvrez le fichier de configuration php.ini avec un éditeur de texte, par exemple avec Visual Studio Code ou un éditeur en ligne de commande : <br>
```sudo code /etc/php/8.3/fpm/php.ini``` <br>
Remplacez la ligne memory_limit pour augmenter la limite de mémoire : <br>
Trouvez la ligne : memory_limit = 128M <br>
Remplacez-la par : memory_limit = 2G

### Étape 3 : Modification du fichier de configuration www\.conf
Ouvrez le fichier de configuration des pools FPM : <br>
```sudo code /etc/php/8.3/fpm/pool.d/www.conf``` <br>
Modifiez les lignes concernant l'utilisateur et le groupe pour les adapter à votre environnement : <br>
Trouvez les lignes : <br>
user = www-data <br>
group = www-data <br>
Remplacez-les par, par exemple : <br>
user = mon_user (Utilisez la commande whoami pour obtenir votre nom d'utilisateur) <br>
group = staff

### Étape 4 : Redémarrage de PHP-FPM
Redémarrez le service PHP-FPM pour appliquer les modifications : <br>
```sudo service php8.3-fpm restart```

[Retour à la page d'accueil](../README.md)<br>
[Suite](nginx-config.md)