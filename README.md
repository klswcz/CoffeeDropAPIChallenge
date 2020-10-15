# Coffee Drop API

## Setup
 
Clone repository into your current folder  
 `git clone https://github.com/klswcz/CoffeeDropAPIChallenge.git`  

Change you directory to _coffee-drop_  
`cd CoffeeDropAPIChallenge/coffee-drop/`  

Pull Docker submodule  
`git submodule update --init`  

Run `composer install`

Inside _coffee-drop_ directory create _.env_ file and paste this configuration
 ```
 APP_NAME=coffee-drop
 APP_ENV=development
 APP_KEY=base64:t4wc+1umoEuccgV34ktDqqA32itcmXEEpUKIo6pcjK4=
 APP_DEBUG=true
 APP_URL=0.0.0.0:80
 
 LOG_CHANNEL=stack
 
 DB_CONNECTION=mysql
 DB_HOST=mysql
 DB_PORT=3306
 DB_DATABASE=coffee_drop
 DB_USERNAME=root
 DB_PASSWORD=root
 
 BROADCAST_DRIVER=log
 CACHE_DRIVER=file
 QUEUE_CONNECTION=sync
 SESSION_DRIVER=file
 SESSION_LIFETIME=120
 
 REDIS_HOST=127.0.0.1
 REDIS_PASSWORD=null
 REDIS_PORT=6379
 
 MAIL_MAILER=smtp
 MAIL_HOST=smtp.mailtrap.io
 MAIL_PORT=2525
 MAIL_USERNAME=null
 MAIL_PASSWORD=null
 MAIL_ENCRYPTION=null
 MAIL_FROM_ADDRESS=null
 MAIL_FROM_NAME="${APP_NAME}"
 
 AWS_ACCESS_KEY_ID=
 AWS_SECRET_ACCESS_KEY=
 AWS_DEFAULT_REGION=us-east-1
 AWS_BUCKET=
 
 PUSHER_APP_ID=
 PUSHER_APP_KEY=
 PUSHER_APP_SECRET=
 PUSHER_APP_CLUSTER=mt1
 
 MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
 MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
 ```

To start Docker container move into _laradock_ folder  
`cd laradock`  

Create _.env_ file  
`cp env-example .env`  

Run _docker_compose_ command 
`docker-compose up -d nginx mysql`  

Create a new database named 'coffee_drop' (mysql configuration is host 127.0.0.1:3306, user: root, password: root)  

To run migrations and seeders change your directory again to laradock and run
`docker-compose exec workspace bash`  

When you're inside container run `php artisan migrate:fresh --seed` and after migration and after seeding is done `exit` the container. 

**Your application should be running on http://localhost:80/**

## How to run unit tests?
To run unit tests access container CLI  
`docker-compose exec workspace bash`  

When you're inside container run `php artisan test` and `exit` to quit the container. 
