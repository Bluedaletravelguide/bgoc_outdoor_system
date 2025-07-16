## About This Project

MDT Ticketing System Project project is a Facility Management which comprises of web and mobile based application. <br>

```
Framework: Laravel 10.30.1
PHP version: 8.1.16
Node version: v18.17.1
Mobile application: Flutter
```


- [ERD Design](https://dbdiagram.io/d/mdt_ticketing_system-66f11c80a0828f8aa6b832b4)
```
- [Project Architecture and Specs](https://1drv.ms/x/s!AmZPObK7qS5FlKBrJeKkDLRydsdFIg?e=bDLoBm)
- [JIRA](https://mdtrd.atlassian.net/jira/software/c/projects/ANC/boards/2)
- [Slides on ANC Flow Process](https://1drv.ms/b/s!AmZPObK7qS5FlKBvp0ZIjN7W7PXm3A?e=u8NWDp)
```

### How to run this code?
```
composer install
npm install && npm run dev
php artisan serve
```

### Database migration and seeds
```
php artisan key:generate
php artisan migrate --seed
```

You can create a local database for development purposes.

### Optimize application
```
php artisan optimize:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:cache
php artisan view:cache
php artisan clear-compiled
php artisan config:cache
```

### Compile Scripts For Local/Dev Environemnt ###
```
npm run dev
```

### Compile and Minify Scripts For Production Environemnt ###
```
npm run prod
```
