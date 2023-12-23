# Laravel 8 and Vue 2 JS Project

This is a basic Laravel project that you can use as a starting point for your web application. Follow the instructions below to get started.

## Getting Started

### Prerequisites

Before you can launch this project, you need to have the following software installed on your computer:

- [PHP](https://www.php.net/manual/en/install.php) (7.3 or later)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/download/)
- [npm](https://www.npmjs.com/get-npm)

### Installing

1. Clone this repository to your local machine.
2. Navigate to the project directory.
3. Run `composer install` to install the PHP dependencies.
4. Run `npm install` to install the Node.js dependencies.
5. Copy the `.env.example` file to `.env` and update the database credentials.
6. Run `docker-compose up -d`
7. Connect to a shell terminal inside a docker container `docker exec -it app bash`
8. Run `php artisan key:generate` to generate an application key.
9. Run `php artisan migrate --seed` to run the database tables and seeders.


### Launching

To launch this project, follow these steps:

1. Navigate to the project directory.
2. In a separate terminal window, run `php artisan serve` to start the Laravel development server.
3. In your web browser, navigate to `http://localhost:8876/` to view the application.

### Building

- [Laravel](https://laravel.com/) - The PHP web framework used
- [Vue.js](https://vuejs.org/) - The JavaScript framework used
- [Bootstrap](https://getbootstrap.com/) - The CSS framework used

To build the assets for production, run the following command:
npm run prod

This will create optimized versions of the CSS and JavaScript files in the `public` directory.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

- [Laravel Documentation](https://laravel.com/docs) - For their great documentation on how to get started with Laravel.
