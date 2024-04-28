## Configuration de base nginx

### Étape 1 : Création du fichier de configuration
En étant à la racine de votre os, créez un dossier config, et un fichier base.conf à l'intérieur : <br>
```code config/base.conf``` <br>

Coller le contenu suivant dans le fichier base.conf : <br>
```bash
server {
    listen 80;
    listen [::]:80;
    server_name {{host}};
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;

    ssl_certificate      /etc/nginx/ssl/{{host}}.crt;
    ssl_certificate_key  /etc/nginx/ssl/{{host}}.key;
    ssl_ciphers          HIGH:!aNULL:!MD5;
    
    server_name {{host}};
    root   {{root}}/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;

    location / {
        try_files $uri /index.php?$query_string;
    }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        # fastcgi_pass 127.0.0.1:9081; /// a changer avec socket
        fastcgi_pass            unix:/run/php/php8.3-fpm.sock;

        fastcgi_index index.php;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Étape 2 : Configuration du fichier des alias
Dans le fichier .bash_aliases, ajoutez les alias suivants : (le créer à la racine s'il n'existe pas) <br>
```bash
alias nginxrestart="sudo service nginx restart"
alias nginxstart="sudo service nginx start"
alias nginxstatus="sudo service nginx status"
alias nginxlistavailable="sudo ls -l /etc/nginx/sites-available"
alias nginxlistenable="sudo ls -l /etc/nginx/sites-enabled"
alias nginxlistssl="sudo ls -l /etc/nginx/ssl"
alias phpfpmstart="sudo service php8.3-fpm start"
alias phpfpmrestart="sudo service php8.3-fpm restart"
alias sf="php bin/console"

function nginxcreate() {
    if [ ! -d /etc/nginx/sites-enabled ]; then
        sudo mkdir /etc/nginx/sites-enabled
        sudo chown $(whoami):$(whoami) /etc/ngonx/sites-enbaled
        sudo chmod 777 /etc/ngonx/sites-enbaled
    fi

    if [ ! -d /etc/nginx/ssl ]; then
        sudo mkdir -p /etc/nginx/ssl
        sudo chown $(whoami):$(whoami) /etc/nginx/ssl
        sudo chmod 777 /etc/nginx/ssl
    fi

    sudo cp $HOME/config/base.conf /etc/nginx/sites-available/$1.conf
    sudo sed -i "s:{{host}}:$1:" /etc/nginx/sites-available/$1.conf
    sudo chmod 777 /etc/nginx/sites-available/$1.conf

    if [ "$3" ]; then
        sudo sed -i "s:{{root}}:$3:" /etc/nginx/sites-available/$1.conf
    else
        sudo sed -i "s:{{root}}:$(pwd)/$1:" /etc/nginx/sites-available/$1.conf
    fi

    nginxaddssl $1

    sudo ln -s /etc/nginx/sites-available/$1.conf /etc/nginx/sites-enabled/$1.conf
    sudo chmod 777 /etc/nginx/sites-enabled/$1.conf

    nginxrestart
    nginxstatus

    echo "127.0.0.1     $1" | sudo tee -a /etc/hosts
    code /etc/hosts

    nginxedit $1
    nginxlistavailable
    nginxlistenable
    nginxlistssl
}

function nginxaddssl() {
    echo "[SAN]\nsubjectAltName=DNS:$1" > /tmp/$1_openssl.cnf
    cat /etc/ssl/openssl.cnf >> /tmp/$1_openssl.cnf

    sudo openssl req \
       -x509 -sha256 -nodes -newkey rsa:2048 -days 3650 \
       -subj "/CN=$1" \
       -config /tmp/$1_openssl.cnf \
       -keyout /etc/nginx/ssl/$1.key \
       -out /etc/nginx/ssl/$1.crt

    sudo cp /etc/nginx/ssl/$1.crt /usr/local/share/ca-certificates/
    sudo update-ca-certificates

    rm /tmp/$1_openssl.cnf
    sudo chmod 777 /etc/nginx/ssl/$1.key /etc/nginx/ssl/$1.crt
}

function nginxedit() {
    code /etc/nginx/sites-available/$1.conf
}

function nginxclean() {
    if [ -f /etc/ssl/certs/$1.pem ]; then
        sudo rm /etc/ssl/certs/$1.pem
        echo "remove pem"
    fi
    sudo rm /etc/nginx/ssl/$1.key
    sudo rm /etc/nginx/ssl/$1.crt
    if [ -f /etc/nginx/sites-enabled/$1.conf ]; then
        sudo rm /etc/nginx/sites-enabled/$1.conf
        echo "remove enable"
    fi
    if [ -f /etc/nginx/sites-available/$1.conf ]; then
        sudo rm /etc/nginx/sites-available/$1.conf
        echo "remove available"
    fi
    sudo sed -i "/127.0.0.1\s*$1/d" /etc/hosts
}

echo "$(phpfpmstart)"
echo "$(nginxstart)"
```

[Retour à la page d'accueil](../README.md)<br>
[Suite](docker.md)