<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateSubscriptionsTable extends AbstractMigration
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
        $table = $this->table('subscriptions');
        $table->addColumn('userid', 'string', ['limit' => 32])
            ->addColumn('subscriber', 'string', ['limit' => 32])
            ->addColumn('status', 'string')
            ->addColumn('cancel_url', 'string')
            ->addColumn('update_url', 'string')
            ->addColumn('started', 'integer', ['limit' => 32])
            ->addColumn('next_bill', 'integer', ['limit' => 32])
            ->addColumn('active', 'boolean')
            ->create();
    }
}
