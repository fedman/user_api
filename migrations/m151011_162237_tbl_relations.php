<?php

use yii\db\Schema;
use yii\db\Migration;

class m151011_162237_tbl_relations extends Migration
{
    /**
     * @var string Table name
     */
    private $table = 'friendship';
    
    public function up()
    {
        $columns = [
            'uid1' => $this->integer()->notNull(),
            'uid2' => $this->integer()->notNull(),
        ];
        $this->createTable($this->table, $columns);
        $this->createIndex('uid1_uid2', $this->table, ['uid1', 'uid2'], true);
    }

    public function down()
    {
        $this->dropTable($this->table);
    }
}
