<?php

namespace backend\modules\M5\controllers;

use Yii;
use common\models\M5;
use common\models\Config;
use backend\models\M5MapSearch;
use backend\models\M5Search;
use backend\modules\M5\models\CreateMemberTake;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for M5 model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all M5 models.
     * @return mixed
     */
    public function actionAll()
    {
        $searchModel = new M5Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single M5 model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $searchModel = new M5MapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$model);
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionRun($id){
        $model = $this->findModel($id);
        $model->EndTime();
        return $this->redirect(['view', 'id' => $model->id]);
    }
    /**
     * Creates a new M5 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionIndex(){
        $is_run = Config::getValueConfig('m5_run');
        $title = Config::getValueConfig("nameApp");
        if ($is_run == 0) {
            return $this->render('home',['run'=>$is_run,'title'=>$title]);
        }  else {
            return $this->render('home_run',['run'=>$is_run,'title'=>$title]);
        }
    }
    public function actionCreatetake()
    {
        $model = new CreateMemberTake();

        if ($model->load(Yii::$app->request->post()) && $model->saveData()) {
            return $this->redirect(['view', 'id' => $model->m5_id]);
        }
    }

    /**
     * Updates an existing M5 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing M5 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the M5 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return M5 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = M5::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
