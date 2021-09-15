# Astral Website

## First time setup
1. Rename and configure config.php.
2. Run `composer install`.
3. Create a `cache` folder in the root directory, permissions may need to be changed.
4. Run `php vendor/bin/phinx migrate` in the root directory.
5. Run `php vendor/bin/phinx seed:run` in the root directory
6. Start up the Redis & SQL server.
7. Profit?

## Migrations

### Creating a new migration
1. `vendor/bin/phinx create TestMigration`

### Running the latest migrations
1. `vendor/bin/phinx migrate`

## Possible other issues and their fixes:

### ImageMagick module not available with this PHP installation.
[Likely redundant issue] Fix: Put `extension=imagick.so` in your php.ini file. (https://stackoverflow.com/questions/46824621/imagemagick-module-not-available-with-this-php-installation-on-laravel-5-4-with)

### The openssl extension is required for SSL/TLS protection but is not available.
Fix: OpenSSL needs to be enabled in php.ini. Likely multiple packages need enabling