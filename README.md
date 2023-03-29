# Elephant CMS

**Description**: Simple in use and easy to modify as it satisfy your needs, yet comes with elephant like big features.

Other things to include:

-   **Technology stack**: This CMS is built with Laravel PHP Framework and support MySQL (tested) and PostgreSQL.
-   **Status**: This is an initial release and still in development and testing phase . Kindly refer "Roadmap" for upcoming features.


## Dependencies

All dependencies can be auto-downloaded using `php artisan composer install` command on first installation. Apart from this, you need a web server which supports PHP version 8+ and MySQL version 8.x

## Installation

1. Clone this project or download latest version archive
2. Navigate to your project location and then open terminal
3. Run  `cp .env.example .env`  file to copy example file to  `.env`  
    Then edit your  `.env`  file with DB credentials and other settings
4. Run `cp .env.example .env` file to copy example file to .env
5. Then edit your .env file with DB credentials and other settings.
6. Run `composer install` command
7. Run `php artisan migrate --seed` command. **Notice:** seed is important, because it will create the first admin user for you.
8. Run `php artisan key:generate` command.
9. Run `php artisan storage:link` command.

## Configuration

##### Default credentials
Username:  `admin@admin.com`  
Password:  `password`


## How to test the software

In project run following command to perform unit testing
`php artisan test`


## Known issues

## Getting help

## Getting involved

## Open source licensing info

1.  [GPL v3.0](https://github.com/shivampandya24/Elephant-CMS/blob/main/LICENSE)

----------

## Credits and references

1.  WordPress CMS who inspired me ♥