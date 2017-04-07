<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cycle".
 *
 * @property integer $id
 * @property integer $cronjob_id
 * @property string $title
 * @property integer $min
 * @property integer $max
 * @property integer $count_day
 * @property integer $date_begin
 * @property integer $date_end
 * @property integer $status
 */
class Cycle extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_START = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cycle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cronjob_id', 'min', 'max', 'count_day', 'status'], 'integer'],
        ];
    }
    public static function create() {
        $current = self::current();
        if ($current) {
            $current->status = self::STATUS_START;
            $current->save();
        }
        $min = Config::getValueConfig('m5_cycle_min');
        $max = Config::getValueConfig('m5_cycle_max');
        $day = Config::getValueConfig('m5_cycle_count_day');
        $model = new Cycle;
        $model->max = $max;
        $model->min = $min;
        $model->status = self::STATUS_ACTIVE;
        $model->count_day = $day;
        if ($model->save()) {
            $date = date('d-m-Y H:i:s');
            $date1 = date('d-m-Y H:i:s', strtotime("+$day " .Config::getValueConfig('type_add_time'), strtotime($date)));
            $cronjob = CronJob::create($model->id,self::tableName());
            $model->cronjob_id = $cronjob->id;
            Cron::setCronRun($date1,$cronjob);
            $model->date_end = date('Y-m-d H:i:00', strtotime($date1));
            $model->save();
        }
        
    }
    public static function current() {
        return self::findOne(['status'=>  self::STATUS_ACTIVE]);
    }
    //kết thúc môt chu kì
    public function End() {
        $members = Member::find()->where(['!=','role_id',  Member::ROLE_DISABLE])->andWhere(['status'=>  Member::STATUS_ACTIVE])->all();
//        die('co vao day k'.count($members));
        foreach ($members as $member) {
            $m5 = $member->getGivecycle()->where(['>=','status',  M5::STATUS_END])->all();
            if (count($m5) < $this->min) {
                Punish::create($member, $this);
            }
        }
        self::create();
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cronjob_id' => Yii::t('app', 'Cron ID'),
            'title' => Yii::t('app', 'Title'),
            'min' => Yii::t('app', 'Min'),
            'max' => Yii::t('app', 'Max'),
            'count_day' => Yii::t('app', 'Count Day'),
            'date_begin' => Yii::t('app', 'Date Begin'),
            'date_end' => Yii::t('app', 'Date End'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
