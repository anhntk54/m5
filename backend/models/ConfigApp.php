<?php

namespace backend\models;
use common\models\Config;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class ConfigApp extends \yii\db\ActiveRecord
{
    public $baseUrl;
    public $nameApp;
    public $tinh_id, $huyen_id, $xa_id;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['baseUrl',  'nameApp','tinh_id','huyen_id','xa_id'], 'string', 'max' => 255]
        ];
    }
    public static function getValueConfig($str){
        $config = Config::findOne(['name'=>$str]);
        if ($config) {
            return $config->value;
        }
    }
    public static function setValueConfig($str,$value){
        $config = Config::findOne(['name'=>$str]);
        if ($config) {
            $config->value = $value;
            $config->save();
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'baseUrl' => 'Đường dẫn web',
            'nameApp' => 'Tên hệ thống',
        ];
    }
}
