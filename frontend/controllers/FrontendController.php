<?php

/**
 * Created by PhpStorm.
 * User: trieunhu
 * Date: 3/24/17
 * Time: 5:07 PM
 */
namespace frontend\controllers;
use common\models\Member;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
class FrontendController extends Controller{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $model = Member::findOne(Yii::$app->user->id);
            if ($model && $model->status < Member::STATUS_ACTIVED){
                if ($this->action->id != 'info' && !Yii::$app->user->isGuest) {
                    $this->redirect(Url::to(['/Member/default/info']));
                }
            }

            return true; // or false if needed
        } else {
            return false;
        }
    }
    public function init() {
//        var_dump( Yii::$app->controller);
//        die();
        parent::init();
    }
}