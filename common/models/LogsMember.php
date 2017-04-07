<?php

namespace common\models;

use Yii;
use common\func\FunctionCommon;
/**
 * This is the model class for table "logs_member".
 *
 * @property integer $id
 * @property integer $member_id
 * @property integer $table_id
 * @property string $table_name
 * @property string $value
 * @property integer $ip_address
 * @property string $created_at
 */
class LogsMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['member_id', 'table_id', 'table_name', 'value', 'ip_address'], 'required'],
            [['member_id', 'table_id'], 'integer'],
            [['created_at'], 'safe'],
            [['table_name'], 'string', 'max' => 25],
            [['ip_address'], 'string', 'max' => 250],
            [['value'], 'string', 'max' => 255]
        ];
    }
    function getMember(){
        return $this->hasOne(Member::className(),['id'=>'member_id']);
    }
    public static function create($table_id,$table_name,$member_id,$value){
        if (Config::getValueConfig('create_logs_member') == 1) {
            try{
                $model = new self();
                $model->table_name = $table_name;
                $model->table_id = $table_id;
                $model->member_id = $member_id;
                $model->value = $value;
                $model->created_at = date('Y-m-d H:i:s');
                $model->ip_address = FunctionCommon::getIP();
                $model->save();
                return $model;
            }catch (Exception $e){
                echo "loi gì dây <br>";
                die(var_dump($e));
            }
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'table_id' => Yii::t('app', 'Table ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'value' => Yii::t('app', 'Value'),
            'ip_address' => Yii::t('app', 'Ip Address'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
