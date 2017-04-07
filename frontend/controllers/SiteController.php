<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup', 'test', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            // change layout for error action
            if ($action->id == 'error')
                $this->layout = "@app/views/layouts/main-login.php";
            return true;
        } else {
            return false;
        }
    }

    public function actionTest() {
        \common\models\Email::create("anhntk54@gmail.com", "tuan anh", "test");
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionError() {
//        die('vao day k');

        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            
            return $this->render('error', ['exception' => $exception]);
        }
    }

}
