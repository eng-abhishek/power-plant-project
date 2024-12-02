## Power Plant Project

## Installation Guide
   
### Create ENV file ###

### Install Composer ###
composer install


### Run migration ###
php artisan migrate

### Run Seeder ###
php artisan db:seed


### Super Admin login ###
http://127.0.0.1:8000/superadmin/login
#### In local system. Login details Email:admin@gmail.com And Password : 123456789 ####


### Create Power Plant User ###
Super Admin create the power plant user, with emial id and password and we send email to that user this email and password

### Role management ###
Super Admin can make any user as power plant user or admin


### Power Plant User Login ###
#### http://127.0.0.1:8000/login or http://127.0.0.1:8000/  in our local system power plant user can login using these urls. ####

### Create scheduling ###
Each power plant user can create own schedile.
Super Admin can also create schedule of all the users

 