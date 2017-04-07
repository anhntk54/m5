<?php

namespace frontend\modules\M5\controllers;
use common\models\M5Map;
use common\models\M5;
use frontend\controllers\FrontendController;
use Yii;
use frontend\modules\M5\models\M5MapView;
use common\models\Member;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class M5mapController extends FrontendController {
     public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['index', 'view'],
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

    public function actionIndex($id) {
        $m5 = M5::findOne($id);
        if ($m5) {
            $model = [];
            if ($m5->viewed == M5::VIEW_END) {
                if ($m5->type == M5::TYPE_GIVE) {
                    $model = $m5->getGives()->where(['viewed'=> M5Map::VIEW_END])->all();
                } else {
                    $model = $m5->getTakes()->where(['viewed'=> M5Map::VIEW_END])->all();
                }
            }
            return $this->render('index', ['model' => $model,'m5'=>$m5]);
        }  else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionView($id) {
        $model = M5MapView::findOne($id);
        $member = Member::findOne(\Yii::$app->user->id);
        $count_pin = count($member->pins);
        if ($model) {
            // die(var_dump(count($model->m5take->takes)));
            if (Yii::$app->request->post()) {
                $model->load(Yii::$app->request->post());
                if ($model->saveData()) {
                    $title = Yii::t("app", 'COUNT_MONEY_SUCCESS');
                    if ($model->report == 1) {
                        $title = Yii::t("app", 'M5_MAP_CREATE_REPORT_SUCCESS');
                    }
                    Yii::$app->session->setFlash('success', $title);
                    return $this->redirect(['/M5/m5map/view','id'=>$id]);
                }
            }
            return $this->render('view', ['value' => $model,'count_pin'=>$count_pin]);
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
