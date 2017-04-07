<?php

namespace backend\modules\config\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $value
 * @property string $table_name
 * @property string $type
 * @property integer $menu_order
 */
class Menu extends \common\models\Menu {

    public $json_value, $select_menu, $header_menu, $footer_menu, $sidebar_menu;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'menu';
    }

    function getChilds() {
        return $this->hasMany(Menu::className(), ['parent_id' => 'id']);
    }

    function getParent() {
        return $this->hasOne(Menu::className(), ['id' => 'parent_id']);
    }

    public function Xoa() {
        foreach ($this->childs as $value) {
            if ($value) {
                $value->Xoa();
            }
        }
        if ($this->parent_id > 0) {
            $this->delete();
        }
    }

    public function setTypeMenu($type) {
        $model = Menu::findOne(['type' => $type]);
        if ($model && $model->id != $this->id) {
            $model->type = '';
            $model->save(FALSE);
        }
        $this->type = $type;
        $this->save(FALSE);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['parent_id', 'menu_order', 'header_menu', 'footer_menu', 'sidebar_menu'], 'integer'],
            [['name', 'value', 'table_name', 'type'], 'string', 'max' => 255],
            [['json_value'], 'string',]
        ];
    }

    public static function saveMenu($name, $value, $table_name, $parent_id, $opentab = 0, $order = 0, $type = '') {
        $model = new Menu();
        $model->parent_id = $parent_id;
        $model->name = $name;
        $model->value = $value;
        $model->menu_order = $order;
        $model->table_name = $table_name;
        $model->type = $type;
        $model->new_tab = $opentab;
        $model->save(FALSE);
        return $model;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'value' => 'Value',
            'table_name' => 'Table Name',
            'type' => 'Type',
            'menu_order' => 'Menu Order',
        ];
    }

}
