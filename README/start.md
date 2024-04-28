# Démarage du projet

dans le terminal dans le dossier du projet <br>
créer la base de donnée :<br>
`sf doc:db:create` (sf est le raccourci ajouté plus tôt, sinon php bin/console)<br>
mettre à jour la db<br>
`sf doc:sch:up --dump-sql --force --complete`

/!\ Uniquement pour ce projet : (pour charger les données)<br>
`sf app:import-sport data/sports.csv`<br>
`sf doc:fix:load --append`