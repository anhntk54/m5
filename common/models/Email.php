<?php

namespace common\models;

use Yii;

class Email extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
        ];
    }

    public static function create($emailTo, $subject, $content, $layout = 'layouts/html') {
        $emailSend = Yii::$app->mailer->compose(['html' => $layout], ['content' => $content])
                ->setFrom(["m5.hotro@gmail.com"=>"Hỗ Trợ"])
                ->setTo($emailTo)
                ->setSubject($subject);
        $emailSend->send();
    }

}
