
## Running app locally

running backend
```
cd simple-app
composer install
php artisan migrate:fresh --seed
php artisan serve
```

running frontend
```
cd simple-app-vue
npm install
npm run dev
```

If the ports do not align (backend 8000), please proceed accordingly or contact Vladimir Čeko directly