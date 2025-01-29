# Test Task / etaktik / Laravel

## React Admin

You can install and run the React Admin by following the steps below:

```bash
cd admin

# install dependencies
npm ci

# run the server
npm run dev
```

and open [http://localhost:5173](http://localhost:5173) in your browser.

## Laravel API

### Database
You have to run database server, you can do it by running the following command:

```bash
docker compose -f docker-compose.dev.yml up
```

### API server
Now you can install and run the Laravel API by following the steps below:

```bash
cd api

# setup the environment
cp .env.example .env

# install dependencies
composer install

# generate the application key
php artisan key:generate

# run the migrations and seed the database
php artisan migrate
php artisan db:seed

# run the server
php artisan serve
```

and open [http://localhost:8000](http://localhost:8000) in your browser.

### Tests
Also you can run basic tests by running the following command:

```bash
php artisan test
```

### OpenAPI specification

You can regenerate the OpenAPI specification by running the following command:

```bash
php artisan scribe:generate
```

and open [http://localhost:8000/docs](http://localhost:8000/docs) in your browser.
