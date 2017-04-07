<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160921_145444_create_multi_level extends Migration
{
    public function up() {
        $this->createTable('multi_level', [
            'id' => Schema::TYPE_PK,
             'tree' => Schema::TYPE_INTEGER,
            'lft' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rgt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'depth' => Schema::TYPE_INTEGER . ' NOT NULL',
            'table_name' => Schema::TYPE_STRING . ' NOT NULL',
            'table_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('multi_level');
    }
}
