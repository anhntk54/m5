<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "level".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $money
 * @property integer $percent
 * @property integer $condition
 * @property string $type
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'money', 'percent', 'condition', 'type'], 'required'],
            [['content'], 'string'],
            [['money', 'percent', 'condition'], 'integer'],
            [['name', 'type'], 'string', 'max' => 255]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
            'money' => Yii::t('app', 'Money'),
            'percent' => Yii::t('app', 'Percent'),
            'condition' => Yii::t('app', 'Condition'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
}
