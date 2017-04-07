<?php

namespace backend\modules\posts\controllers;

use Yii;
use backend\modules\posts\models\Posts;
use \backend\modules\posts\models\PostRelationships;
use backend\modules\posts\models\Taxonomy;
use backend\modules\posts\models\PostSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Trangthai;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/**
 * DefaultController implements the CRUD actions for Posts model.
 */
class DefaultController extends \backend\controllers\BackendController {

    public function behaviors() {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => TRUE,
                        'actions' => ['index', 'page', 'xoa', 'filerindex', 'create', 'update', 'delete', 'view'],
                        'roles' => ['managePost']
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
    public function actionIndex($filer = 0,$type = 'post') {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $filer,$type);

        $linkAjax = Url::to("?r=posts/default/filerindex");
        $countAll = Posts::find()->where(['type'=>$type])->count();
        $countNotActive = Posts::find()->where(['status' => Posts::STATUS_DRAFT,'type'=>$type])->count();
        $countTake = Posts::find()->where(['status' =>Posts::STATUS_TRASH,'type'=>$type])->count();
        $arrTitle = [
          ['count'=>$countAll,'title'=>'Tất cả','filer'=>0,'type'=>$type],
          ['count'=>$countNotActive,'title'=>'Bản nháp','filer'=>  Posts::STATUS_DRAFT  ,'type'=>$type],
          ['count'=>$countTake,'title'=>'Thùng rác','filer'=>Posts::STATUS_TRASH,'type'=>$type],
        ];
        $dataListAction = ArrayHelper::map(Trangthai::find()->where(['type' => "filerindex"])->all(), 'id', 'ten');

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'filer' => $filer,
                    'type' => $type,
                    'arrTitle'=>$arrTitle,
                    'dataProvider' => $dataProvider,
                    'dataList'=>$dataListAction,
                    'linkAjax'=>$linkAjax
        ]);
    }

    public function actionPage($filer = 5) {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $filer, 'page');

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'filer' => $filer,
                    'type' => 'page',
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFilerindex() {
        if (isset($_POST['ids']) && isset($_POST['action'])) {
            $data = json_decode(stripslashes($_POST['ids']));
            $action = $_POST['action'];
            foreach ($data as $d) {
                $model = Member::findOne($d);
                $trangthai = Trangthai::findOne(['id' => $action]);
                if ($model && $trangthai) {
                    $value = $trangthai->getValue();
                    if ($value == -1) {
                        $model->_delete();
                    } else {
                        $feild = $trangthai->getFeild();
                        if (!empty($feild)) {
                            $model->$feild = $value;
                            $model->save();
                        }
                    }
                }
            }
        }
    }

    /**
     * Displays a single Posts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type = 'post') {
        $model = new Posts();
        if ($model->load(Yii::$app->request->post())) {
            $model->author_id = \Yii::$app->user->id;
            $model->slug = Taxonomy::createSlug($model->id, $model->title, Posts::tableName());
            $model->type = $type;
            $model->save();
            $this->createPosts($model,TRUE,TRUE,FALSE);
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->getSeoPost();
        if ($model->load(Yii::$app->request->post())) {
            PostRelationships::deleteAll(['post_id' => $model->id, 'post_table' => Posts::tableName()]);
            $this->createPosts($model,TRUE,TRUE,FALSE);
            $model->slug = Taxonomy::createSlug($model->id, $model->slug, Posts::tableName(), FALSE);
            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionXoa($id) {
        $model = $this->findModel($id);
        if ($model) {
            $model->Xoa();
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model) {
            $model->Xoa();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
