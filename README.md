# Astral Website

## Note
This was originally going to be a complete suite for a community I was working on. I have since stopped working on that community, and it seems a waste to have this repo sit private. This project is running a custom PHP stack based on Laravel with a themed version of Fomantic UI for the front end. Feel free to learn from it or something.


## Requirements
1. A PHP 7.4 server.
2. Composer, the PHP package manager
3. An SQL database
4. A Redis server. PHP extensions may be required
5. NodeJS & NPM.

## First time setup
1. Rename and configure config.php.
2. Run `composer install`.
3. Create a `cache` folder in the root directory, permissions may need to be changed.
4. Rename `sample.config.php` to `config.php` and configure it.
5. Run `php vendor/bin/phinx migrate` in the root directory.
6. Run `php vendor/bin/phinx seed:run` in the root directory.
7. Run `npm install -g gulp`.
8. Run `npm install`. 
9. Run `cd node_modules/fomantic-ui`.
10. Run `npx gulp build`.
11. Start up the Redis & SQL server.
12. Profit?

## Migrations

### Creating a new migration
1. `vendor/bin/phinx create TestMigration`

### Running the latest migrations
1. `vendor/bin/phinx migrate`

## Fomantic

### Build changes
1. `cd node_modules\fomantic-ui`
2. `npx gulp build`


## Possible other issues and their fixes:

### ImageMagick module not available with this PHP installation.
[Likely redundant issue] Fix: Put `extension=imagick.so` in your php.ini file. (https://stackoverflow.com/questions/46824621/imagemagick-module-not-available-with-this-php-installation-on-laravel-5-4-with)

### ImageMagick module not available with this PHP installation.
Fix: `sudo apt-get install php-imagick`


### The openssl extension is required for SSL/TLS protection but is not available.
Fix: OpenSSL needs to be enabled in php.ini. Likely multiple packages need enabling

