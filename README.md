## SetUp flow
- Install Docker & docker-compose
- RUN "cp .evn.example .env"
- Run "docker-compose up --build"

## Run flow

- SSH into container "sender-workspace-1"
- Run "php artisan notification:push email reminder [1,2,3]"
- All queue work you can see in "sernder-queue-1" container
- All errors fall into log file


All files can be found in domains/sender folder
Mail driver set to LOG
for all other driver .env file should be filled with corresponding variables
