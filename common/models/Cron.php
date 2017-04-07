<?php

namespace common\models;

use yii\helpers\Url;
use Yii;
use yii2tech\crontab\CronTab;
use DateTime;
use common\func\FunctionCommon;

/**
 * This is the model class for table "cron".
 *
 * @property integer $id
 * @property string $min
 * @property string $date_end
 * @property string $hour
 * @property string $day
 * @property string $month
 * @property string $param
 * @property string $command
 * @property integer $status
 */
class Cron extends \yii\db\ActiveRecord {

    const STATUS_RUN = 0;
    const STATUS_NOT_RUN = -1;
    const COUNT_KEY_CODE = 10;

    public function getTextDate() {
        
    }

    public static function getTextStatus() {
        return [
            self::STATUS_RUN => 'Chưa thực thi',
            self::STATUS_NOT_RUN => 'Đã thực thi',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'cron';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['status'], 'integer'],
            [['min', 'hour', 'day', 'month', 'command'], 'string', 'max' => 255]
        ];
    }

    function getJobs() {
        return $this->hasMany(CronJob::className(), ['cron_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'min' => Yii::t('app', 'Min'),
            'date_end' => Yii::t('app', 'Date End'),
            'hour' => Yii::t('app', 'Hour'),
            'day' => Yii::t('app', 'Day'),
            'month' => Yii::t('app', 'Month'),
            'param' => Yii::t('app', 'Url'),
            'command' => Yii::t('app', 'Command'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function run() {
        $this->removeCronJob();
        foreach ($this->jobs as $value) {
            $value->run();
        }
    }

    public function Finish() {
        $i = 0;
        foreach ($this->jobs as $value) {
            if ($value->status != CronJob::STATUS_END) {
                $i++;
            }
        }
        if ($i == 0) {
            $this->removeCronJob();
        }
    }

    public function removeCronJob() {
        $cronTab = new CronTab();
        $cronTab->setJobs([
            [
                'day' => $this->day,
                'month' => $this->month,
                'min' => $this->min,
                'hour' => $this->hour,
                'command' => $this->command,
            ],
        ]);
        $cronTab->remove();
        $this->status = self::STATUS_NOT_RUN;
        $this->save();
    }

    public function getLinkCron() {
        $link = Config::getValueConfig('baseUrl') . Url::to(['/M5/cron/check', 'id' => $this->id, 'code' => $this->code]);
        return $link;
    }

    public static function setCronEvery() {
        $hour = "*";
        $min = "*/".Config::getValueConfig('time_cron');
        $day = "*";
        $month = "*";
        $model = new Cron;
        $model->min = $min;
        $model->hour = $hour;
        $model->day = $day;
        $model->month = $month;
        $link = Config::getValueConfig('baseUrl') . Url::to(['/M5/cron']);
        $model->command = 'curl ' . $link;
        if ($model->save(false)) {
            $cronTab = new CronTab();
            $cronTab->setJobs([
                [
                    'day' => $day,
                    'month' => $month,
                    'min' => $min,
                    'hour' => $hour,
                    'command' => $model->command,
                ],
            ]);
            $cronTab->apply();
        }
    }

    public function updateCron($time) {
        $time = DateTime::createFromFormat("d-m-Y H:i:s", $time);
        $hour = $time->format('H');
        $min = $time->format('i');
        $day = $time->format('d');
        $month = $time->format('m');
        $this->min = $min;
        $this->hour = $hour;
        $this->day = $day;
        $this->month = $month;
        $cronTab = new CronTab();
        $cronTab->setJobs([
            [
                'day' => $day,
                'month' => $month,
                'min' => $min,
                'hour' => $hour,
                'command' => $this->command,
            ],
        ]);
        $cronTab->apply();
        $this->status = self::STATUS_RUN;
        $this->save();
    }

    public static function setCronRun($tnow, $cronjob) {
        $time = DateTime::createFromFormat("d-m-Y H:i:s", $tnow);
        $hour = $time->format('H');
        $min = $time->format('i');
        $day = $time->format('d');
        $month = $time->format('m');
        $model = Cron::findOne(['min' => $min, 'hour' => $hour, 'day' => $day, 'month' => $month]);
        $isNew = FALSE;
        if (!$model) {
            $model = new Cron;
            $model->min = $min;
            $model->hour = $hour;
            $model->day = $day;
            $model->month = $month;
            $model->code = md5(FunctionCommon::random_code(self::COUNT_KEY_CODE));
            $isNew = TRUE;
        } else {
            if ($model->status == self::STATUS_NOT_RUN) {
                $isNew = TRUE;
            }
        }
        $model->date_end = date('Y-m-d H:i:s', strtotime($tnow));
        $model->status = self::STATUS_RUN;
        if ($model->save(FALSE)) {
            $cronjob->setCronId($model->id, $tnow);
            $link = $model->getLinkCron();
            $model->command = 'curl ' . $link;
            $model->save();
            if ($isNew) {
                $cronTab = new CronTab();
                $cronTab->setJobs([
                    [
                        'day' => $day,
                        'month' => $month,
                        'min' => $min,
                        'hour' => $hour,
                        'command' => $model->command,
                    ],
                ]);
                $cronTab->apply();
            }
        }
        return $model->id;
    }

}
