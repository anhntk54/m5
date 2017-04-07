<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

class m160920_153345_create_menu_table extends Migration {

    public function up() {
        $this->createTable('{{%menu_demo}}', [
            'id' => Schema::TYPE_PK,
             'tree' => Schema::TYPE_INTEGER,
            'lft' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rgt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'depth' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down() {
        $this->dropTable('menu_table');
    }

}
