<?php

namespace backend\modules\config\controllers;

use Yii;
use backend\modules\config\models\Trangthai;
use backend\modules\config\models\TrangthaiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TrangthaiController implements the CRUD actions for Trangthai model.
 */
class TrangthaiController extends Controller
{
    public $types = ['batdongsan'=>'batdongsan','status'=>'Status','filerindex' =>'filerindex'];
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','create','update','delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Trangthai models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TrangthaiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Trangthai model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Trangthai model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $arrtypes = Trangthai::find()->all();
        $types = [];
        
        foreach ($arrtypes as $value) {
            $types[$value->type] = $value->type;
        }
        array_unique($types);
        $model = new Trangthai();
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->type_select != '') {
                $model->type = $model->type_select;
                $model->save();
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'types'=>$types,
            ]);
        }
    }

    /**
     * Updates an existing Trangthai model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $arrtypes = Trangthai::find()->all();
        $types = [];
        foreach ($arrtypes as $value) {
            $types[$value->type] = $value->type;
        }
        array_unique($types);
        $model->type_select = $model->type;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->type_select != '') {
                $model->type = $model->type_select;
                $model->save();
            }
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'types'=>$types
            ]);
        }
    }

    /**
     * Deletes an existing Trangthai model.
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
     * Finds the Trangthai model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Trangthai the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Trangthai::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
