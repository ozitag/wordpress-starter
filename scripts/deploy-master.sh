cd {{PROJECT_PATH}}

sudo chown ozitag:ozitag -R .

sudo docker image prune -a --force
sudo docker container prune --force

git fetch --all
git reset --hard origin/master
git clean -f -d

mv .env.production .env
mv src/.env.production src/.env

sudo apt install nodejs
sudo apt install npm
sudo npm install -g yarn
cd src/public/wp-content/themes/app/html
sudo apt-get -y install libjpeg-dev libpng-dev libtiff-dev libgif-dev
yarn install
yarn build

cd {{PROJECT_PATH}}
sudo docker-compose -f docker-compose.yml --project-name {{PROJECT_NAME}} up --build --force-recreate -d