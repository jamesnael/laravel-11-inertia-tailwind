# ERIA
### Installation

1. Clone the repository

2. Change to directory

````
cd eria-webprofile
````   

3. Install dependencies

````
composer install
````

4. Copy .env file

```
cp .env.example .env
```

5. Modify `DB_*` value in `.env` with your database config.

6. Generate application key:

````
php artisan key:generate
````

7. Migrate
````
php artisan migrate
````

8. Install Node modules
````
npm install
````

9. Build

````
npm run dev
````
or
````
npm run watch
````

### Database Data

1. Generate the db seeder

````
php artisan db:seed
````

3. Testing the data
```
Login with :
username : demo-admin
password : password
```

<br>
<b>PT Total Solusi Teknologi</b>