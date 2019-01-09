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

# Step 10 : Set Permission
+ sudo chmod -R 777 public/logos
+ sudo chmod -R 777 storage
+ sudo chmod -R 777 public/avatars

# Step 11: Run project
+ npm run watch-poll
+ cd server_node => node server
+ redis-server --port "your_port"