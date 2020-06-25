cd {{PROJECT_PATH}}

sudo -u www-data git fetch --all
sudo -u www-data git reset --hard origin/develop
sudo -u www-data git clean -f -d

mv .env.development .env
mv src/.env.development src/.env

cd src/public/wp-content/themes/app/html
sudo -u www-data yarn install
sudo -u www-data yarn build

cd {{PROJECT_PATH}}
sudo docker-compose -f docker-compose.dev.yml --project-name {{PROJECT_NAME}} up --build --force-recreate -d
