# Astral Website

## First time setup
1. Rename and configure config.php.
2. Rename and configure phinx.php.
3. Run `composer install`.
4. Create a `cache` folder in the root directory, permissions may need to be changed.
5. Run `vendor/bin/phinx migrate` in the root directory.
6. Start up the Redis server.
7. Profit?

## Migrations

### Creating a new migration
1. `vendor/bin/phinx create TestMigration`

### Running the latest migrations
1. `vendor/bin/phinx migrate`