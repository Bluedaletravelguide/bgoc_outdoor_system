## About This Project

BGOC Outdoor Billboard Management System is a custom-built Laravel web application designed to efficiently manage and monitor outdoor billboard advertising operations. It enables administrators, team leaders, and technicians to handle work orders, scheduling, site status, and updates in real-time through a clean and organized dashboard.

The system aims to streamline billboard asset maintenance, assign technician tasks, track ongoing work, and store historical updates — all within a secure role-based access platform. <br>

✨ Key Features <br>
🔧 Work Order Management – Create, assign, and track maintenance or installation tasks  <br>
👥 Role-Based Access Control – Separate dashboards for admin, team leaders, and technicians <br>
📍 Billboard Asset Tracking – Monitor location, status, and technical info of each billboard <br>
📅 Schedule & Updates – Track work progress and updates with timestamps <br>
📊 Dashboard View – Centralized view of ongoing, upcoming, and completed work <br>
🗂️ PDF/CSV Export – Export reports and data for operational use <br>

```
Framework: Laravel 10.48.29
PHP version: 8.2.26
Node version: v22.17.0
```


- [ERD Design](https://drive.google.com/file/d/15AkB-HTuZ8RdxGwRb8vj9bcq-r0L9zg-/view?usp=sharing)

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
php artisan migrate:fresh --seed
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
