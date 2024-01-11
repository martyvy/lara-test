## SetUp flow
- Install Docker & docker-compose
- Run "docker-compose up --build"

## Run flow

- SSH into container "sender-workspace-1"
- Run "php artisan sender:push email reminder [1,2,3]"
- All queue work you can see in "sernder-queue-1" container
- All errors fall into log file
