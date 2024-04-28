## Configuration de Docker

### Étape 1 : Fichier de configuration
En étant à la racine de votre os, créez un dossier config, et un fichier docker-compose.yaml à l'intérieur : <br>
````code config/docker-compose.yaml````<br>
Coller le contenu suivant dans le fichier docker-compose.yaml : <br>
```yaml
version: '3.7'

services:
  db:
    image: 'bitnami/mariadb:latest'
    restart: always
    environment:
      MARIADB_ROOT_PASSWORD: root
    ports:
      - "3306:3306"
    volumes:
      - mariadb-data:/usr/local/share/db/data

  phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    restart: always
    ports:
      - 8000:80
    environment:
      # - PMA_ARBITRARY=1
      - PMA_HOST=db
      - UPLOAD_LIMIT=2G
    depends_on:
      - db

  mailcatcher:
    restart: always
    container_name: mailcatcher
    image: dockage/mailcatcher
    network_mode: bridge
    ports:
      - "25:1025"
      - "1080:1080"

  elasticsearch:
    image: docker.elastic.co/elasticsearch/elasticsearch:7.10.2-amd64
    container_name: elasticsearch
    environment:
      - xpack.security.enabled=false
      - discovery.type=single-node
      - ES_JAVA_OPTS=-Xms750m -Xmx750m
    ulimits:
      memlock:
        soft: -1
        hard: -1
      nofile:
        soft: 65536
        hard: 65536
    cap_add:
      - IPC_LOCK
    volumes:
      - elasticsearch-data:/usr/local/share/elasticsearch/data
    ports:
      - 9200:9200
      - 9300:9300
    networks:
      - elastic

  kibana:
    container_name: kibana
    image: docker.elastic.co/kibana/kibana:7.10.0
    environment:
      - ELASTICSEARCH_HOSTS=http://elasticsearch:9200
    ports:
      - 5601:5601
    depends_on:
      - elasticsearch
    networks:
      - elastic

volumes:
  mariadb-data:
    driver: local
  mariadb-test:
    driver: local
    driver_opts:
      o: bind
      type: none
      device: /usr/local/share/db/data
  elasticsearch-data:
    driver: local
  elasticsearch-56-data:
    driver: local

networks:
  elastic:
    driver: bridge
```

### Étape 2 : Démarrage de Docker
Pour démarrer les services Docker, exécutez les commandes suivantes : <br>
`cd config`<br>
`docker build`<br>
`docker compose up -d`<br>
(ou lancer le conteneur dans Docker Desktop)

[Retour à la page d'accueil](../README.md)<br>
[Suite](installation.md)