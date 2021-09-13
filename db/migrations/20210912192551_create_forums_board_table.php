<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateForumsBoardTable extends AbstractMigration
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
        $table = $this->table('forums_boards');
        $table->addColumn('parent_id', 'integer', ['limit' => 32])
            ->addColumn('name', 'string', ['limit' => 128])
            ->addColumn('description', 'string', ['limit' => 256])
            ->addColumn('creator', 'string', ['limit' => 32])
            ->addColumn('created', 'integer', ['limit' => 32])
            ->addForeignKey('parent_id', 'forums_boards', 'id')
            ->create();
    }
}
