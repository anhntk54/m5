<?php

namespace backend\modules\config\models;

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
    public $m5_time_end_give;
    public $m5_roses_direct;
    public $m5_roses_sytem_1;
    public $m5_roses_sytem_2;
    public $m5_roses_sytem_3;
    public $m5_roses_sytem_4;
    public $m5_roses_sytem_5;
    public $type_add_time;
    public $m5_cycle_min;
    public $m5_cycle_max;
    public $m5_cycle_count_day;
    public $m5_price;
    public $m5_precent;
    public $m5_time_pending_transaction;
    public $m5_time_pending_transaction_gd;
    public $m5_time_action_transaction;
    public $m5_count_pd;
    public $send_mail;
    public $create_logs_member;
    public $time_cron;
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
            [['baseUrl','nameApp','type_add_time'], 'string', 'max' => 255],
            [['m5_time_end_give', 'm5_roses_direct','m5_roses_sytem_1',
              'm5_roses_sytem_2','time_cron','create_logs_member','m5_roses_sytem_3','m5_roses_sytem_4','m5_roses_sytem_5',
              'm5_cycle_min','m5_cycle_max','m5_cycle_count_day','m5_price','m5_precent','m5_time_pending_transaction','m5_time_action_transaction','m5_count_pd','send_mail','m5_time_pending_transaction_gd'],'integer']
        ];
    }
    public function getTypeAddTime()
    {
        return [
            'min'=>'Min',
            'hours'=>'Hours',
            'days'=>'Day',
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
            'm5_time_end_give'=>'Thời gian kết thúc cho',
            'm5_roses_direct'=>'Hoa hồng trực tiếp',
            'm5_roses_sytem_1'=>'Hoa hồng hệ thống cấp 1',
            'm5_roses_sytem_2'=>'Hoa hồng hệ thống cấp 2',
            'm5_roses_sytem_3'=>'Hoa hồng hệ thống cấp 3',
            'm5_roses_sytem_4'=>'Hoa hồng hệ thống cấp 4',
            'm5_roses_sytem_5'=>'Hoa hồng hệ thống cấp 5',
            'type_add_time'=>'Thời gian',
            'm5_cycle_min'=>'Hoa hồng tối thiểu trong một vòng',
            'm5_cycle_max'=>'Hoa hồng tối đa trong một vòng',
            'm5_cycle_count_day'=>'Thời gian của vòng',
            'm5_price'=>'Tiền đăng ký PD',
            'm5_precent'=>'Phần trăm nhận được',
            'm5_time_pending_transaction'=>'Thời gian chờ PD',
            'm5_time_pending_transaction_gd'=>'Thời gian chờ GD',
            'm5_time_action_transaction'=>'Thời gian giao dịch',
            'm5_count_pd'=>'Số lượng đăng ký PD được tặng hoa hồng',
            'send_mail'=>'Gửi mail giao dịch',
            'create_logs_member'=>'Tạo log người dùng',
            'time_cron'=>'Thời gian chạy tự động',
        ];
    }
}
