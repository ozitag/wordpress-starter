For local development:

1. Configure .env files (./env ./src/.env)

2. run `docker-compose -f docker-compose.dev.yml --project-name {PROJECT_NAME} up --build --force-recreate -d`

3. after first run you have to wait 3 mins while composer installing dependencies