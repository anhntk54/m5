<?php

namespace backend\modules\config\models;

use Yii;

/**
 * This is the model class for table "trangthai".
 *
 * @property integer $id
 * @property string $ten
 * @property string $mo_ta
 * @property string $type
 * @property string $thuoc_tinh
 */
class Trangthai extends \common\models\Trangthai
{
    public $type_select;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trangthai';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ten'], 'required'],
            [['mo_ta'], 'string'],
            [['ten'], 'string', 'max' => 255],
            [['type','type_select', 'thuoc_tinh'], 'string', 'max' => 22]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Ten',
            'mo_ta' => 'Mo Ta',
            'type' => 'Type',
            'thuoc_tinh' => 'Thuoc Tinh',
        ];
    }
}
