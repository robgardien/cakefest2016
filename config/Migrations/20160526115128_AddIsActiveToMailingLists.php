<?php
use Migrations\AbstractMigration;

class AddIsActiveToMailingLists extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('mailing_lists');
        $table->addColumn('is_active', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addIndex([
            'is_active',
        ], [
            'name' => 'BY_IS_ACTIVE',
            'unique' => false,
        ]);
        $table->update();
    }
}
