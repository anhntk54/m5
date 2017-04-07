<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class Config extends \yii\db\ActiveRecord
{
    const M5_TYPE_TIME = 'min';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
    public static function isSendMail(){
        return self::getValueConfig('send_mail') == 1;
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
}
