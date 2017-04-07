<?php

namespace app\models;

use Yii;

/**
 * This is the model class for collection "LogsMember".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $table_id
 * @property mixed $table_name
 * @property mixed $value
 */
class LogsMember extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['xemdb', 'LogsMember'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'table_id',
            'table_name',
            'value',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_id', 'table_name', 'value'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => Yii::t('app', 'ID'),
            'table_id' => Yii::t('app', 'Table ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
}
