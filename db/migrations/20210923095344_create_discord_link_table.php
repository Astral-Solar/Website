<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDiscordLinkTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {

        $table = $this->table('users_discord');
        $table->addColumn('userid', 'string', ['limit' => 32])
            ->addColumn('discord_id', 'string', ['limit' => 256])
            ->addColumn('name', 'string', ['limit' => 256])
            ->addColumn('created', 'integer', ['limit' => 32])
            ->addForeignKey('userid', 'users', 'userid')
            ->create();
    }
}
