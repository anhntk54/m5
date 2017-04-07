<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "roses".
 *
 * @property integer $id
 * @property integer $m5_id
 * @property integer $member_id
 * @property double $money
 * @property double $percent
 * @property string $type
 */
class Roses extends \yii\db\ActiveRecord
{
  const TYPE_DIRECT = "direct";
  const TYPE_SYSTEM = "system";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roses';
    }
    public static function setRoses($m5_id,$member_id,$percent,$type,$money)
    {
        $model = new Roses;
        $model->m5_id = $m5_id;
        $model->member_id = $member_id;
        $model->percent = $percent;
        $model->money = $money;
        $model->type = $type;
        $model->save();
        return $model;

    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['m5_id', 'member_id', 'money', 'percent', 'type'], 'required'],
            [['m5_id', 'member_id'], 'integer'],
            [['money', 'percent'], 'number'],
            [['type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'm5_id' => Yii::t('app', 'M5 ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'money' => Yii::t('app', 'Money'),
            'percent' => Yii::t('app', 'Percent'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
}
