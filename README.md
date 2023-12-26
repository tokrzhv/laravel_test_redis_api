# Laravel Dockerized Project
This Laravel project is Dockerized and includes Swagger/OpenAPI documentation for the API. It uses Docker containers for Redis, MySQL, and Nginx.

## Getting Started

### Prerequisites
Before you can launch this project, you need to have the following software installed on your computer:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)


### Installing

1. Clone this repository to your local machine.
2. Navigate to the project directory.
3. Copy the `.env.example` file to `.env` and update the database credentials.
4. Run Docker Compose to set up the containers `docker-compose up -d`
5. Install PHP dependencies `docker-compose exec app composer install`
6. Run `docker-compose exec app php artisan key:generate php artisan key:generate` to generate an application key.
7. Run `docker-compose exec app php artisan key:generate php artisan migrate --seed` to run the database tables and seeders. 
8. Access the Laravel application at http://localhost:8876/.


### Launching
To launch this project, follow these steps:

1. Navigate to the project directory.
2. In your web browser, navigate to `http://localhost:8876/api/documentation` to view the api documentation.


### Docker Containers
The Docker setup includes the following containers:

- app: Laravel application container.
- mysql: MySQL database container.
- redis: Redis container.
- nginx: Nginx container serving the Laravel application.

### Container Details

#### MySQL

- Host: 127.0.0.1
- Port: 8101
- Username: root
- Password: root

#### Redis

- Connection name: redis
- Host: 127.0.0.1
- Port: 6379
- Password: 1111


### Swagger/OpenAPI Documentation
Generating API Documentation :

- docker-compose exec app php artisan l5-swagger:generate


### Viewing API Documentation
Once generated, the API documentation is available at:

http://localhost/api/documentation


### Additional Information
For more information on using Swagger/OpenAPI in Laravel, refer to the L5 Swagger GitHub repository.

Adjust the .env file configurations as needed for your specific environment setup.

### Building

- [Laravel](https://laravel.com/) - The PHP web framework used
- [Bootstrap](https://getbootstrap.com/) - The CSS framework used

To build the assets for production, run the following command:
npm run prod

This will create optimized versions of the CSS and JavaScript files in the `public` directory.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

- [Laravel Documentation](https://laravel.com/docs) - For their great documentation on how to get started with Laravel.
