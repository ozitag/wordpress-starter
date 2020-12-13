cd /srv/{{PROJECT_PATH}}

sudo chown gitlab:gitlab -R .

sudo -u gitlab git fetch --all
sudo -u gitlab git reset --hard origin/develop
sudo -u gitlab git clean -f -d

cp .env.development .env
cp src/.env.development src/.env

cd src/public/wp-content/themes/app/html
sudo apt -y install libjpeg-dev libpng-dev libtiff-dev libgif-dev ca-certificates fonts-liberation libappindicator3-1 libasound2 libatk-bridge2.0-0 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgbm1 libgcc1 libglib2.0-0 libgtk-3-0 libnspr4 libnss3 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 lsb-release wget xdg-utils

sudo -u gitlab yarn install
sudo -u gitlab yarn build

cd {{PROJECT_PATH}}
sudo docker-compose -f docker-compose.dev.yml --project-name awem up --build --force-recreate -d
