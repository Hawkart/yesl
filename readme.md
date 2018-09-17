## eSports Social Network 
It's sSports social network developed using the Laravel PHP framework.

### Installation
* git clone https://github.com/Hawkart/yesl.git projectname
* cd projectname
* composer install
* php artisan key:generate to regenerate secure key
* create new database and edit .env file for DB settings
* php artisan migrate —seed
* edit .env file for APP configuration and Social API Configurations
* storage, bootstrap/cache and public/cache directories should be writable
* php artisan storage:link
* php artisan serve

### Features
* Create a profile with a username, profile picture, cover picture and personal information
* Make comments on Posts, Images
* Like Posts, Images

### Requirements
* PHP 7.2
* MySQL