admin
cd admin
npm ci
npm run dev

api
cp .env.example .env
cd api
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve

docker compose -f docker-compose.dev.yml up
