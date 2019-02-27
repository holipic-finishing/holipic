# Holipic
Holipic Project
# How to install

# Step 1: Clone sourcecode
git clone git@bitbucket.org:luongtd/holipic.git

# Step 2: Go to holipic
cd holipic

# Step 3: Create .env file
cp .env.example .env

# Step 4: Config app key
php artisan key:generate

# Step 5: Install redis server
+ Follow link Ubuntu: https://www.digitalocean.com/community/tutorials/how-to-install-and-secure-redis-on-ubuntu-18-04
+ Follow link Window: https://github.com/tporadowski/redis/releases

# Step 6: Install composer, npm, redis server, bower 
+ composer install
+ npm install
+ redis-server --port "your_port_config_in_env"
+ bower install

# Step 7: Config .env
+ Config database
+ Config domain
+ Config protocol
+ Config port (redis, socket)

# Step 8: Migrate and seeding 
php artisan migrate
php artisan db:seed

# Step 9: Create folder
+ public/logos
+ public/avatars
+ public/files
+ public/image_uploads
+ public/photographers
	- public/photographers/avatars
	- public/phototgraphers/identification

# Step 10 : Set Permission
+ sudo chmod -R 777 public/logos
+ sudo chmod -R 777 storage
+ sudo chmod -R 777 public/avatars
+ sudo chmod -R 777 public/files
+ sudo chmod -R 777 public/image_uploads
+ sudo chmod -R 777 public/photographers

# Step 11: Run project
+ npm run watch-poll
+ cd server_node => node server
+ redis-server --port "your_port"

# Step 12: Config Https
+ config https with apache2: 
	+ https://www.digitalocean.com/community/tutorials/how-to-create-a-self-signed-ssl-certificate-for-apache-in-ubuntu-16-04
	+ https://www.digitalocean.com/community/tutorials/how-to-create-a-self-signed-ssl-certificate-for-apache-in-ubuntu-18-04
+ install openssh: sudo apt-get install openssh-server
+ copy file : apache-selfsigned.crt and apache-selfsigned.key to rsa_key folder