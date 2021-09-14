<?php


use Phinx\Seed\AbstractSeed;

class RegisterSuperAdmin extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $table = $this->table('groups');
        $table->insert([
            'name' => "Super Admin",
            'identifier' => "superadmin",
            'creator' => "0",
            'created' => time()
        ])
            ->saveData();
    }
}
