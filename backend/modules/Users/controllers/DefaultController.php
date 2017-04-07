<?php

namespace backend\modules\Users\controllers;

use yii\web\Controller;
use common\models\Member;
class DefaultController extends Controller
{
    public function actionIndex()
    {
        $model = Member::findOne(3);
        echo '<pre>';
        die(var_dump($model->getTree($model->id)));
        return $this->render('index');
    }
}
