# Astral Website

## First time setup
1. Rename and configure config.php.
2. Run `composer install`.
3. Create a `cache` folder in the root directory, permissions may need to be changed.
4. Run `vendor/bin/phinx migrate` in the root directory.
5. Start up the Redis server.
6. Profit?

## Migrations

### Creating a new migration
1. `vendor/bin/phinx create TestMigration`

### Running the latest migrations
1. `vendor/bin/phinx migrate`