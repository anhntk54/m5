<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cron_job".
 *
 * @property integer $id
 * @property integer $table_id
 * @property string $table_name
 * @property string $date_end
 * @property integer $status
 */
class CronJob extends \yii\db\ActiveRecord {

    const STATUS_START = 0;
    const STATUS_END = 1;
    
    public static function getTextStatus() {
        return [
            self::STATUS_START=> 'Chưa thực thi',
            self::STATUS_END => 'Đã thực thi',
        ];
    }
    function getCron() {
        return $this->hasOne(Cron::className(), ['id' => 'cron_id']);
    }
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cron_job';
    }
    public function isNotRunCron() {
        if ( $this->status == self::STATUS_START) {
            $date = $this->date_end;
            $now = date('Y-m-d H:i:s');
            if (strtotime($now) > strtotime($date)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public static function create($table_id, $table_name) {
        $model = CronJob::findOne(['table_id' => $table_id, 'table_name' => $table_name]);
        if (!$model) {
            $model = new CronJob;
            $model->table_id = $table_id;
            $model->table_name = $table_name;
        }
        $model->status = self::STATUS_START;
        $model->save();
        return $model;
    }
    public function Finish() {
        $this->status = self::STATUS_END;
        $this->save();
        if ($this->cron) {
            $this->cron->Finish();
        }
    }
    public function run() {
        
        if ($this->status == self::STATUS_START) {
            $_id = $this->table_id;
            $_class = $this->table_name;
            $this->status = self::STATUS_END;
            $this->save();
            if ($_class == M5Map::tableName()) {
                $m5 = M5Map::findOne($_id);
                if ($m5) {
                    $m5->EndTime();
                }
            } else if ($_class == Cycle::tableName()) {
                $cycle = Cycle::findOne($_id);
                if ($cycle) {
                    $cycle->End();
                }
            } elseif ($_class == M5::tableName()) {
                $m5 = M5::findOne($_id);
                if ($m5) {
                    $m5->EndTime();
                }
            }
        }
    }

    public function setCronId($cron_id,$date) {
        $this->cron_id = $cron_id;
        $this->date_end = date('Y-m-d H:i:s',  strtotime($date));
        $this->save();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['table_id', 'status'], 'integer'],
            [['table_name'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'table_id' => Yii::t('app', 'Table ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

}
