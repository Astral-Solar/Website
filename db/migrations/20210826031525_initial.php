<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Initial extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('userid', 'string', ['limit' => 32])
            ->addColumn('name', 'string')
            ->addColumn('avatar', 'text')
            ->addColumn('background', 'string')
            ->addColumn('lastseen', 'integer', ['limit' => 32])
            ->addColumn('joined', 'integer', ['limit' => 32])
            ->create();
    }
}
