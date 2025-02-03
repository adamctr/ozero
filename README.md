// Créer BDD
docker run --name ozero -p 3310:3306 -e MYSQL_ROOT_PASSWORD=123 -d mysql

// Se connecter avec DBEAVER à la bdd

// Faire à l'installation :
composer install
npm install
renommer dotenvsample en .env et remplir les champs

// Lancer le watch de tailwindcss
npx tailwindcss -i ./public/style/style.css -o ./public/style/output.css --watch

// Lancer le serveur (front)
php -S localhost:8000 -t public

// Aller sur http://localhost:8000/login

// Pour les requetes JS il faut préciser dans le fetch AJAX:
headers: {
'Content-Type': 'application/json',
}

-- products
-- blog
-- cart
-- user 
-- auth
-- 

