docker compose up --build -d

docker exec -it app composer install

docker exec -it app php artisan migrate:refresh --seed

DB_CONNECTION=pgsql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=lmfrotas
DB_USERNAME=user
DB_PASSWORD=secret

php artisan key:generate  

sudo chown -R $USER:$USER /home/andre/projetos/moot/moot_lm-frotas_teste

npm cache clean --force

npm install
