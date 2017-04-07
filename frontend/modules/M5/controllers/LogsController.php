<?php

namespace frontend\modules\M5\controllers;

use frontend\controllers\FrontendController;
use yii\filters\VerbFilter;
use common\models\Logs;
use common\models\Member;
use Yii;

class LogsController extends FrontendController {

    public $limit = 15;

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['index', 'view', 'more'],
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionMore() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $count = $request->post('count');
            $offser = $count * $this->limit;
            $model = Logs::find()->where(['member_id' => \Yii::$app->user->id])->orderBy(['id' => SORT_DESC])->offset($offser)->limit($this->limit)->all();
            return $this->renderPartial('more', ['model' => $model]);
        }
    }

    public function actionIndex() {
        $model = Logs::find()->where(['member_id' => \Yii::$app->user->id])->orderBy(['id' => SORT_DESC])->limit($this->limit)->all();
        return $this->render('index', ['model' => $model]);
    }

    public function actionView() {
        $member = Member::findOne(Yii::$app->user->id);
        if ($member) {
            $condition = "is_view=" . Logs::VIEW_BEGIN . " AND member_id=" . $member->id;
            Logs::updateAll(['is_view' => Logs::VIEW_END], $condition);
        }
    }

}
