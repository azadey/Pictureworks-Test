# Pictureworks Test Setup
Test Project done for Pictureworks.

## First Time Setup

Follow these steps.

Change directory in to your project folder.

    git clone git@github.com:azadey/pictureworks-test.git

Type following in your terminal. 
Docker image will be build if this is your first time running docker-compose.

    cp .env.example .env
    
    docker-compose up -d

    sudo nano /etc/hosts

    cd app
        
    cp .env.exampe .env

    sudo chown -R {your current user}:http storage

    sudo chown -R {your current user}:http bootstrap/cache

    chmod -R 775 storage

    chmod -R 775 bootstrap/cache

Make necessary changes in the .env file.

Add following line to hosts file.

> 192.168.37.14   local-picwork

Now lets set up the project. Run the following commands
    
    cd ../

    make picwork-bash

    composer install

    php artisan key:generate

    php artisan config:cache

    php artisan migrate

    php artisan db:seed

Rest API routes for user comments CRUD

CREATE

    POST http://{APP NAME}/api/user-comment

    {
	    "name" : "Samuel",
	    "comments" : "My First post for comments"
    }

GET
    
    GET http://{APP NAME}/api/user-comment/1
    
UPDATE

    PATCH http://{APP NAME}/api/user-comments/1

    {
	    "name" : "Samuel Brent",
	    "comments" : "My post / comments update"
    }

DELETE
    
    DELETE http://{APP NAME}/api/user-comments/1
    

