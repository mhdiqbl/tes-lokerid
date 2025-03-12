# ASSESMENT LOKER ID

## Requirement
Before running this project, make sure your system has:
- **PHP 8.1** or above
- **Composer**
- **Web Server** (Apache or Nginx)
- **Database** (MySQL)

## Installation
Follow these steps to run the project locally:

### 1. Clone Repository
    git clone https://github.com/mhdiqbl/tes-lokerid.git

### 2. Switch to the repo folder
    cd tes-lokerid

### 3. Install composer
    composer install

### 4. Generate Application Key
    php artisan key:generate

### 5. Run the database migrations
    php artisan migrate

### 6. Start the local server
    php artisan serve

You can now access the server at http://localhost:8000

----------
## Run Testing APi

### Run the laravel development server
    php artisan serve

### Run All Testing
    php artisan test

### Run Swagger UI for Documentation API
    php artisan l5-swagger:generate
