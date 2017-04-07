<?php

namespace frontend\modules\M5\controllers;

use common\models\Member;
use frontend\controllers\FrontendController;
use frontend\modules\M5\models\TransactionsForm;
use yii\filters\VerbFilter;
use Yii;
class PinController extends FrontendController {

	public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['selectmember','create'],
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
    
    public function actionSelectmember() {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $data = [];
            $q = $request->post('q');
            if (!empty($q)) {
                $model = Member::find()->where(['!=','id',  \Yii::$app->user->id])->andFilterWhere(['LIKE','username',$q])->all();
                foreach ($model as $value) {
                    $arr = [];
                    $arr['id']= $value->id;
                    $arr['username']= $value->username;
                    $data[] = $arr;
                }
            }
            echo json_encode($data);
        }
        
    }
    public function actionCreate()
    {
    	$model = new TransactionsForm;
        $member = Member::findOne(Yii::$app->user->id);
        $countPin = $member->pin;
    	if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveData()) {
            Yii::$app->session->setFlash('success',  Yii::t('app', 'PIN_SUCCESS'));
            return $this->redirect(['/M5/pin/create']);
        }
        return $this->render('create',['model'=>$model,'countPin'=>$countPin]);
    }
}
