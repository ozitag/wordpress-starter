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

sudo apt -y install libjpeg-dev libpng-dev libtiff-dev libgif-dev ca-certificates fonts-liberation libappindicator3-1 libasound2 libatk-bridge2.0-0 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgbm1 libgcc1 libglib2.0-0 libgtk-3-0 libnspr4 libnss3 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 lsb-release wget xdg-utils
yarn install
yarn build

cd {{PROJECT_PATH}}
sudo docker-compose -f docker-compose.yml --project-name {{PROJECT_NAME}} up --build --force-recreate -d