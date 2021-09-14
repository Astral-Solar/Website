<?php


use Phinx\Seed\AbstractSeed;

class GiveSuperAdminsGroupEditPerms extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function getDependencies()
    {
        return [
            'RegisterSuperAdmin'
        ];
    }
    public function run()
    {
        $table = $this->table('groups_permissions');
        $table->insert([
            'group_id' => 1,
            'node' => "groups.edit.permissions"
        ])
            ->saveData();
    }
}
