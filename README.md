1. Copy `.env.example` to `.env`
2. `make init` - build project;
3. `make migrations` - migrate db migrations;
4. Create user via command `docker-compose run --rm php-cli php bin/console app:create-user admin 123123`
5. Import all files from `/postman` to your Postman
6. ...
7. Profit

P.S. Tests are available by `make test`