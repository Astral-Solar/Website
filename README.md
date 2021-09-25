# Astral Website

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
4. Run `php vendor/bin/phinx migrate` in the root directory.
5. Run `php vendor/bin/phinx seed:run` in the root directory.
6. Run `npm install -g gulp`.
7. Run `npm install`. 
8. Run `cd node_modules/fomantic-ui`.
9. Run `npx gulp build`.
10. Start up the Redis & SQL server.
11. Profit?

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

