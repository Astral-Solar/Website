<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateThreadPostTableAndRemoveThreadContentColumn extends AbstractMigration
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
        $table = $this->table('forums_threads');
        $table->removeColumn('content')
            ->save();

        $table = $this->table('forums_threads_posts');
        $table->addColumn('thread_id', 'integer', ['limit' => 32])
            ->addColumn('content', 'text')
            ->addColumn('deleted', 'boolean')
            ->addColumn('creator', 'string', ['limit' => 32])
            ->addColumn('created', 'integer', ['limit' => 32])
            ->addColumn('last_edited', 'integer', ['limit' => 32])
            ->addForeignKey('thread_id', 'forums_threads', 'id')
            ->create();
    }
}
