<?php

namespace frontend\modules\M5\controllers;
use frontend\controllers\FrontendController;
use yii\filters\VerbFilter;
use common\models\Member;
use Yii;
use frontend\modules\M5\models\RosesForm;
use common\models\Transactions;
class RosesController extends FrontendController
{
	public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['index', 'view','create'],
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
    public function actionIndex()
    {
        $member = Member::findOne(Yii::$app->user->id);
        if ($member) {
            return $this->render('index',['model'=>$member->roses]);
        }
    }
    public function actionCreate()
    {
        $model = new RosesForm;
        $member = Member::findOne(\Yii::$app->user->id);
        $maxCountRoses = 0;
        if ($member->level) {
            $maxCountRoses = $member->level->count_roses;
        }
        $countOfWeek = Transactions::getCountOfWeek($member);
        $count = $maxCountRoses - $countOfWeek;
        $model->count_pin = $member->pin;
        $model->money = $member->money_roses;
        if (Yii::$app->request->post() && $model->validate() && $model->saveData()) {
            Yii::$app->session->setFlash('success', Yii::t("app", 'ROSES_CREATE_SUCCESS'));
            return $this->redirect(['/M5/roses/create']);
        }
        return $this->render('create', ['model' => $model,'count'=>$count]);
    }


}
