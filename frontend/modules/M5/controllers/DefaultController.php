<?php

namespace frontend\modules\M5\controllers;

use common\models\LogsMember;
use frontend\controllers\FrontendController;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\Member;
use common\models\Config;
use common\models\M5;
use frontend\modules\M5\models\GiveForm;
use Yii;
use common\models\Posts;
use common\models\Category;
use yii\web\NotFoundHttpException;
use common\models\Email;


class DefaultController extends FrontendController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['index','email', 'post', 'give', 'take', 'listpin', 'givepin', 'list', 'listtake', 'changetime'],
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
    public function actionEmail(){
        Email::create("anhntk54@gmail.com","demo","kajkla",[]);

    }

    public function actionList() {
        $member = Member::findOne(Yii::$app->user->id);
        $title = Yii::t('app', 'VIEW_LIST_TITLE_PD');
        if ($member) {
            $model = $member->gives;

            return $this->render('list', ['model' => $model, 'title' => $title]);
        }
    }

    public function actionListtake() {
        $member = Member::findOne(Yii::$app->user->id);
        $title = Yii::t('app', 'VIEW_LIST_TITLE_GD');
        if ($member) {
            $model = $member->takes;
            return $this->render('list', ['model' => $model, 'title' => $title]);
        }
    }

    public function actionChangetime() {
        $data = ['error' => 0];
        if (isset($_POST['id'])) {
            $type = $_POST['type'];
            $id = $_POST['id'];
            if ($type == "m5") {
                $model = M5::findOne($id);
                if ($model) {
                    $data['error'] = 1;
                    $data['status'] = $model->getStatus();
                    $data['date'] = $model->getDate();
                    $data['dateview'] = $model->getTimeEnd();
                }
            }
        }
        echo json_encode($data);
    }


    public function actionIndex($slug = '') {
        $category = Category::find()->where(['status' => 1])->all();
        if (empty($slug)) {
            $cate = @current($category);
        } else {
            $cate = Category::findOne(['slug' => $slug]);
        }
        if (!$cate) {
            $cate = Category::findOne(21);
        }
        $cateQ = Category::findOne(24);
        $posts = $cate->getPosts()->limit(10)->all();
        return $this->render('index', ['category' => $category, 'cate' => $cate, 'cateQ' => $cateQ, 'posts' => $posts]);
    }

    public function actionGive() {
//        $v = M5::findOne(1);
//        $v->createActionTake();
        $model = new GiveForm;
        $member = Member::findOne(\Yii::$app->user->id);
        $model->count_pin = $member->pin;
        $model->money = Config::getValueConfig('m5_price');
//        die(var_dump($model->load(Yii::$app->request->post())));
        if (Yii::$app->request->post() && $model->validate() && $model->saveData()) {
            Yii::$app->session->setFlash('success', Yii::t("app", 'COUNT_MONEY_SUCCESS'));
            return $this->redirect(['/M5/default/give']);
        }
        return $this->render('give', ['model' => $model]);
    }

    public function actionPost($slug) {
        $category = Category::find()->where(['status' => 1])->all();
        $model = Posts::findOne(['slug' => $slug]);
        if ($model) {
            $cate = $model->categories[0];
            return $this->render('post', ['category' => $category, 'cate' => $cate, 'model' => $model]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
