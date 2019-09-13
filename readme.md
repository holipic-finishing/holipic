# Holipic
Holipic Project
# How to install

## Step 1: Clone sourcecode
git clone git@bitbucket.org:luongtd/holipic.git

## Step 2: Go to holipic
cd holipic

## Step 3: Create .env file
cp .env.example .env
chmod 777 .env

## Step 4: Config app key
php artisan key:generate

## Step 5: Install redis server
+ Follow link Ubuntu: https://www.digitalocean.com/community/tutorials/how-to-install-and-secure-redis-on-ubuntu-18-04
+ Follow link Window: https://github.com/tporadowski/redis/releases or https://redislabs.com/blog/redis-on-windows-10/

## Step 6: Config .env
+ Config database
+ Config domain name
+ Config protocol (http or https)
+ Config port (redis, socket)

## Step 7: Install and Run: composer, npm, redis server, bower 
+ composer install
+ npm install
+ bower install

## Step 8: Migrate and seeding 
+ php artisan migrate
+ php artisan db:seed

## Step 9: Create folder
+ public/company_logos
+ public/photographers
+ public/photographers/avatars
+ public/phototgraphers/identifications
+ public/customer_avatars
+ public/files

## Step 10 : Set Permission
+ sudo chmod -R 777 storage
+ sudo chmod -R 777 public/company_logos
+ sudo chmod -R 777 public/photographers
+ sudo chmod -R 777 public/customer_avatars
+ sudo chmod -R 777 public/files

## Step 11: Run project
+ npm run watch-poll or npm run dev
+ cd server_node => node server
+ redis-server --port "your_redis_port_config_in_env"

## Step 12: Config Https
+ config https with apache2: 
    * https://www.digitalocean.com/community/tutorials/how-to-create-a-self-signed-ssl-certificate-for-apache-in-ubuntu-16-04
    * https://www.digitalocean.com/community/tutorials/how-to-create-a-self-signed-ssl-certificate-for-apache-in-ubuntu-18-04
    * https://itshare.online/knowledge/cai-dat-ssl-cho-xampp-tren-windows/amp/

+ install openssh: sudo apt-get install openssh-server
+ copy file : example.crt and example.key to rsa_key folder and modify /server_node/server.js

## Step 13: Install Supervisor
+ https://laravel.com/docs/5.7/queues#supervisor-configuration
+ sudo apt-get install supervisor
+ cd /etc/supervisor/conf.d/
+ sudo touch holipic-worker.conf
+ sudo nano holipic-worker.conf

[program:holipic-worker.conf]
process_name=%(program_name)s_%(process_num)02d
command=php /your-path/holipic/artisan queue:listen --sleep=3 --tries=3
autostart=true
autorestart=true
user=username
numprocs=8
redirect_stderr=true
stdout_logfile=/your-path-logs/supervisor.log

+ Start supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all

## Step 13: Config cronjob
+ sudo crontab -e
+ * * * * * php /your-path/holipic/artisan schedule:run >> /dev/null 2>&1
